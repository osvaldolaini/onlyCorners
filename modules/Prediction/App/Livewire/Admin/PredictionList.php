<?php

namespace Modules\Prediction\App\Livewire\Admin;

use App\Enums\CornerMarketLabel;
use Carbon\Carbon;
use Livewire\Component;
use Modules\Game\App\Models\Game;
use Modules\Prediction\App\Models\Prediction;
use Modules\Prediction\App\Services\CornerPredictionService;
use Modules\Prediction\App\Services\CornerStatsGamesService;
use Modules\Team\App\Models\Team;

class PredictionList extends Component
{
    protected $layout = 'app';

    public $breadcrumb = 'Previsões';
    public $cards = [];

    public $showModalShow = false;
    public $detail;

    // --------------------------------------------------------
    // 📄 RENDER
    // --------------------------------------------------------
    public function render()
    {
        $this->cards = Prediction::where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        return view('prediction::livewire.admin.prediction-list')
            ->layout('layouts.' . $this->layout);
    }



    public function showModal($id)
    {
        $this->showModalShow = true;
        // dd();
        $this->detail = Prediction::find($id);
        // dd($this->detail, $id);
    }

    // --------------------------------------------------------
    // 🚀 GERAR PREDIÇÕES COMPLETAS
    // --------------------------------------------------------
    public function generatePredictions()
    {
        $statsService = new CornerStatsGamesService();
        $cornerService = new CornerPredictionService();

        $games = $this->getGames();

        if (!$games['success']) {
            return;
        }
        // dd(($games));
        if ((count($games['games'])) > 0) {
            // 1️⃣ ANALISA JOGOS
            $predictions = $statsService->analyzeGames(collect($games['games']));

            // 2️⃣ MONTA ENTRADA PARA PYTHON
            $gamesMarkets = $this->buildGamesMarkets($predictions, $cornerService);

            // 3️⃣ EXECUTA PYTHON
            $pythonResponse = $cornerService->generateCardsFromPython($gamesMarkets);

            // 4️⃣ SALVA NO BANCO
            $this->storePythonCards($pythonResponse);

            // 5️⃣ ATUALIZA LISTA
            $this->cards = Prediction::where('status', 'pending')->get();
        } else {
            $this->openAlert('error', 'Não existem jogos no período.');
        }
    }
    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }

    // --------------------------------------------------------
    // 🔧 MONTA MARKETS
    // --------------------------------------------------------
    private function buildGamesMarkets($predictions, $cornerService)
    {
        // dd($cornerService);
        return collect($predictions)->map(function ($p) use ($cornerService) {
            return [
                'game_id' => $p['game_id'],
                'markets' => $cornerService->generateMarketGrid($p['total_corners']),
                'explanation' => $this->generateExplanation($p)
            ];
        })->values()->toArray();
    }



    // --------------------------------------------------------
    // 🐍 SALVA OUTPUT DO PYTHON
    // --------------------------------------------------------
    private function storePythonCards(array $pythonResponse): void
    {

        $statsService = new CornerStatsGamesService();
        $games = $this->getGames();
        $predictions = $statsService->analyzeGames(collect($games['games']));


        foreach (['safe', 'medium', 'aggressive'] as $type) {

            foreach ($pythonResponse[$type] ?? [] as $card) {
                // 🔥 normaliza estrutura (2 formatos possíveis)
                $rawMatches = $card['card'] ?? $card;

                if (!is_array($rawMatches)) {
                    continue;
                }

                $matches = [];

                foreach ($rawMatches as $m) {

                    $g = collect($predictions)->firstWhere('game_id', $m['game_id']);
                    if (!isset($m['game_id'])) {
                        continue;
                    }


                    $matches[] = [
                        'game_id'       => $m['game_id'],
                        'home_team'     => Team::find($g['home_team'])->nick,
                        'away_team'     => Team::find($g['away_team'])->nick,
                        'type'          => $m['type'] ?? null,
                        'odd'           => (float) ($m['odd'] ?? 0),
                        'probability'   => (float) ($m['prob'] ?? $m['probability'] ?? 0),
                        'total_corners' => $g['total_corners'],
                        'explanation'   => $this->generateExplanation($g),
                        'won'           => '',
                        'result_corners' => '',

                    ];
                    // dd($matches);
                }

                if (count($matches) === 0) {
                    continue;
                }

                $hash = $this->generateMatchesHash($matches);

                if (Prediction::where('hash', $hash)->exists()) {
                    continue;
                }

                Prediction::create([
                    'code' => $this->generateUniqueCode(),
                    'type' => $type,
                    'total_matches' => count($matches),
                    'total_odds' => $card['total_odd'] ?? 1,
                    'total_prob' => $card['total_probability'],
                    'matches' => json_encode($matches),
                    'hash' => $hash,
                    'status' => 'pending'
                ]);
            }
        }
    }

    // --------------------------------------------------------
    // 📊 BUSCA JOGOS
    // --------------------------------------------------------
    private function getGames()
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addDays(2)->endOfDay();
        $games = Game::whereBetween('date', ['2026-04-17', $endDate])
            ->where('date', '>', '2026-04-17')
            ->whereDoesntHave('corners')
            ->orderBy('date')
            ->get();
        // $games = Game::whereBetween('date', [$startDate, $endDate])
        //     ->where('date', '>', Carbon::now())
        //     ->whereDoesntHave('corners')
        //     ->orderBy('date')
        //     ->get();
        // dd($games);
        return [
            'success' => true,
            'games' => $games
        ];
    }

    // --------------------------------------------------------
    // 🔑 HASH ÚNICO
    // --------------------------------------------------------
    private function generateMatchesHash(array $matches)
    {
        return md5(
            collect($matches)
                ->map(fn($m) => [
                    'game_id' => $m['game_id'],
                    'type' => $m['type'],
                ])
                ->sortBy('game_id')
                ->values()
                ->toJson()
        );
    }

    // --------------------------------------------------------
    // 🆔 CODE
    // --------------------------------------------------------
    private function generateUniqueCode()
    {
        $date = now()->format('dmY');

        $last = Prediction::whereDate('created_at', now())
            ->orderByDesc('id')
            ->first();

        $next = 1;

        if ($last && preg_match('/-(\d+)$/', $last->code, $m)) {
            $next = (int)$m[1] + 1;
        }

        return 'CARD-' . $date . '-' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }



    public function generateExplanation(array $game): string
    {
        $h = $game['home_advanced'];
        $a = $game['away_advanced'];

        $bet = CornerMarketLabel::from($game['bet'])->label();

        // 🔹 base estatística casa
        $text = "O mandante apresenta média geral de {$h['overall_avg']} escanteios por jogo, ";
        $text .= "com {$h['recent_avg']} nos últimos 5 jogos, que possuem maior peso no modelo. ";

        $text .= "Jogando em casa, a média sobe para {$h['home_home_avg']}, ";
        $text .= "enquanto fora de casa cai para {$h['home_away_avg']}. ";

        // 🔹 visitante
        $text .= "O visitante possui média geral de {$a['overall_avg']} escanteios por jogo, ";
        $text .= "com {$a['recent_avg']} nos últimos 5 jogos. ";

        // 🔹 projeção
        $text .= "A projeção estatística para o confronto é de {$game['total_corners']} escanteios. ";

        // 🔹 leitura do mercado
        if (str_contains($game['bet'], 'over')) {
            $text .= "O cenário indica tendência de jogo mais ofensivo em termos de volume de escanteios.";
        } else {
            $text .= "O cenário sugere um ritmo mais controlado de jogo, com menor volume de escanteios.";
        }

        return $text;
    }
    public function checkResults()
    {
        $cards = Prediction::where('status', 'pending')->get();

        foreach ($cards as $card) {

            $matches = $card->matches;
            // dd($matches);
            $allWon = true;
            $hasPending = false;
            $hits = 0;
            $misses = 0;

            $matches = json_decode($matches, true);

            foreach ($matches as $i => $match) {

                $corners = \Modules\Corner\App\Models\Corner::where('game_id', $match['game_id'])->count();

                if ($corners === 0) {
                    $hasPending = true;
                    continue;
                }

                $matches[$i]['result_corners'] = $corners;

                $won = $this->checkBetResult($match['type'], $corners);

                $matches[$i]['won'] = $won;

                if ($won) {
                    $hits++;
                } else {
                    $misses++;
                    $allWon = false;
                }
            }

            // dd($matches);

            // 🔥 status do card
            if ($hasPending) {
                $card->status = 'pending';
            } else {
                $card->status = $allWon ? 'won' : 'lost';
            }

            // 🔥 salva matches atualizados
            $card->matches = $matches;

            // 🔥 SALVA NO JSON validation
            $card->validation = [
                'hits' => $hits,
                'misses' => $misses,
                'accuracy' => ($hits + $misses) > 0 ? round($hits / ($hits + $misses), 2) : null,
                'checked_at' => now(),
            ];

            $card->save();
            // dd($card);
        }
    }
    private function checkBetResult($bet, $total)
    {
        // dd($bet, $total);
        return match (true) {

            // 🔹 OVER
            str_contains($bet, 'over_6_5') => $total > 6,
            str_contains($bet, 'over_7_5') => $total > 7,
            str_contains($bet, 'over_8_5') => $total > 8,
            str_contains($bet, 'over_9_5') => $total > 9,
            str_contains($bet, 'over_10_5') => $total > 10,
            str_contains($bet, 'over_11_5') => $total > 11,

            // 🔹 UNDER
            str_contains($bet, 'under_13_5') => $total < 14,
            str_contains($bet, 'under_12_5') => $total < 13,
            str_contains($bet, 'under_11_5') => $total < 12,
            str_contains($bet, 'under_10_5') => $total < 11,
            str_contains($bet, 'under_9_5') => $total < 10,
            str_contains($bet, 'under_8_5') => $total < 9,

            default => false
        };
    }
}
