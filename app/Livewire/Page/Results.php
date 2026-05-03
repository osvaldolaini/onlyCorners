<?php

namespace App\Livewire\Page;

use Livewire\Component;

use Modules\Prediction\App\Models\Prediction;

class Results extends Component
{
    // Define o layout a ser usado
    protected $layout = 'page';
    public $cards = [];
    public $breadcrumb = 'Resultados';

    public $showModalShow = false;
    public $detail;

    public $config;
    public $teams;
    public $championships;
    public $corners;

    public $labelsMonth = [];
    public $winsMonth = [];
    public $lossesMonth = [];

    public $labels = [];
    public $wins = [];
    public $losses = [];

    public $labelsMarkets;
    public $winsMarkets;
    public $lossesMarkets;

    public $tableMarkets;

    public $labelsOver;
    public $winsOver;
    public $lossesOver;

    // montar arrays UNDER
    public $labelsUnder;
    public $winsUnder;
    public $lossesUnder;


    public function render()
    {
        $this->cards = Prediction::where('status', '!=', 'pending')
            ->orderByDesc('created_at')
            ->get();
        $this->chart();
        $this->chartByType();

        $this->chartMarkets();
        $this->tableMarkets();
        return view('livewire.page.results')
            ->layout('layouts.' . $this->layout);
    }

    public function showModal($id)
    {
        $this->showModalShow = true;
        // dd();
        $this->detail = Prediction::find($id);
        // dd($this->detail, $id);
    }
    public function chartByType()
    {
        $types = ['safe', 'medium', 'aggressive'];

        $labels = [];
        $wins = [];
        $losses = [];

        foreach ($types as $type) {

            $labels[] = ucfirst($type);

            $wins[] = Prediction::where('type', $type)
                ->where('status', 'won')
                ->count();

            $losses[] = Prediction::where('type', $type)
                ->where('status', 'lost')
                ->count();
        }

        $this->labels = $labels;
        $this->wins = $wins;
        $this->losses = $losses;
    }

    public function chart()
    {
        $months = [];
        $labels = [];
        $wins = [];
        $losses = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            $monthKey = $date->format('Y-m');
            $months[] = $monthKey;

            $labels[] = $date->locale('pt-BR')->translatedFormat('M');
        }

        foreach ($months as $month) {

            $start = \Carbon\Carbon::parse($month)->startOfMonth();
            $end   = \Carbon\Carbon::parse($month)->endOfMonth();

            $wins[] = Prediction::whereBetween('created_at', [$start, $end])
                ->where('status', 'won')
                ->count();

            $losses[] = Prediction::whereBetween('created_at', [$start, $end])
                ->where('status', 'lost')
                ->count();
        }

        $this->labelsMonth = $labels;
        $this->winsMonth = $wins;
        $this->lossesMonth = $losses;
    }
    public function tableMarkets()
    {
        $markets = [];

        $predictions = Prediction::all();

        foreach ($predictions as $prediction) {

            $matches = json_decode($prediction->matches, true);

            if (!$matches) continue;

            foreach ($matches as $match) {

                $type = $match['type'] ?? null;
                $won = $match['won'] ?? null;

                if (!$type) continue;

                if (!isset($markets[$type])) {
                    $markets[$type] = [
                        'wins' => 0,
                        'losses' => 0
                    ];
                }

                if ($won === true) {
                    $markets[$type]['wins']++;
                } else {
                    $markets[$type]['losses']++;
                }
            }
        }

        // 🔥 ordenar por linha numérica
        uksort($markets, function ($a, $b) {
            preg_match('/_(\d+)_(\d+)/', $a, $ma);
            preg_match('/_(\d+)_(\d+)/', $b, $mb);

            $va = ($ma[1] ?? 0) + (($ma[2] ?? 0) / 10);
            $vb = ($mb[1] ?? 0) + (($mb[2] ?? 0) / 10);

            return $va <=> $vb;
        });

        $table = [];

        foreach ($markets as $type => $data) {

            $total = $data['wins'] + $data['losses'];

            $rate = $total > 0
                ? round(($data['wins'] / $total) * 100)
                : 0;

            $table[] = [
                'market' => strtoupper(str_replace('_', '.', $type)), // over_6_5 → OVER 6.5
                'wins' => $data['wins'],
                'losses' => $data['losses'],
                'rate' => $rate
            ];
        }

        $this->tableMarkets = $table;
    }
    public function chartMarkets()
    {
        $over = [];
        $under = [];

        $predictions = Prediction::all();

        foreach ($predictions as $prediction) {

            $matches = json_decode($prediction->matches, true);

            if (!$matches) continue;

            foreach ($matches as $match) {

                $type = $match['type'] ?? null;
                $won = $match['won'] ?? null;

                if (!$type) continue;

                // extrai linha: over_6_5 → 6.5
                preg_match('/_(\d+)_(\d+)/', $type, $m);
                $line = isset($m[1]) ? $m[1] . '.' . $m[2] : 0;

                $target = str_contains($type, 'over') ? $over : $under;

                if (!isset($target[$line])) {
                    $target[$line] = ['wins' => 0, 'losses' => 0];
                }

                if ($won === true) {
                    $target[$line]['wins']++;
                } else {
                    $target[$line]['losses']++;
                }

                // precisa reatribuir (php não é referência automática aqui)
                if (str_contains($type, 'over')) {
                    $over[$line] = $target[$line];
                } else {
                    $under[$line] = $target[$line];
                }
            }
        }

        // 🔥 ordena corretamente
        ksort($over, SORT_NUMERIC);
        ksort($under, SORT_NUMERIC);

        // montar arrays OVER
        $this->labelsOver = array_map(fn($l) => "Over $l", array_keys($over));
        $this->winsOver = array_column($over, 'wins');
        $this->lossesOver = array_column($over, 'losses');

        // montar arrays UNDER
        $this->labelsUnder = array_map(fn($l) => "Under $l", array_keys($under));
        $this->winsUnder = array_column($under, 'wins');
        $this->lossesUnder = array_column($under, 'losses');
    }
}
