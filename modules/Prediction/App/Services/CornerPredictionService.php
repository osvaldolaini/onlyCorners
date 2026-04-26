<?php

namespace Modules\Prediction\App\Services;

use Exception;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CornerPredictionService
{
    /**
     * Gera mercados possíveis (over/under) para um jogo com base na previsão de escanteios.
     * Filtra mercados com probabilidade mínima de 0.40 para reduzir ruído e combinações inúteis.
     */
    public function generateMarketGrid(float $totalCorners): array
    {
        $markets = [];

        $overLines = [
            ['type' => 'over_6_5',  'odd' => 1.10],
            ['type' => 'over_7_5',  'odd' => 1.15],
            ['type' => 'over_8_5',  'odd' => 1.25],
            ['type' => 'over_9_5',  'odd' => 1.40],
            ['type' => 'over_10_5', 'odd' => 1.60],
            // ['type' => 'over_11_5', 'odd' => 1.85],
        ];

        $underLines = [
            ['type' => 'under_13_5', 'odd' => 1.15],
            ['type' => 'under_12_5', 'odd' => 1.25],
            ['type' => 'under_11_5', 'odd' => 1.40],
            ['type' => 'under_10_5', 'odd' => 1.55],
            ['type' => 'under_9_5',  'odd' => 1.75],
            // ['type' => 'under_8_5',  'odd' => 2.05],
        ];

        $calcProbability = function ($line, $isOver) use ($totalCorners) {

            $diff = $isOver
                ? ($totalCorners - $line)
                : ($line - $totalCorners);

            return round(1 / (1 + exp(-$diff)), 2);
        };

        foreach (array_merge($overLines, $underLines) as $line) {

            preg_match('/\d+/', $line['type'], $m);
            $value = (float)($m[0] ?? 0);

            $isOver = str_contains($line['type'], 'over');

            $prob = $calcProbability($value, $isOver);

            // filtro de qualidade
            if ($prob < 0.40) {
                continue;
            }

            $markets[] = [
                'type' => $line['type'],
                'odd' => $line['odd'],
                'probability' => $prob,
            ];
        }

        return $markets;
    }

    /**
     * Envia jogos para o motor Python e retorna os cards prontos:
     * SAFE / MEDIUM / AGGRESSIVE já ranqueados.
     */

    //  $pythonResponse = $this->generateCardsFromPython($gamesMarkets);


    public function generateCardsFromPython(array $gamesMarkets): array
    {

        $pythonExecutable = "C:\\laragon\\bin\\python\\python-3.10\\python.exe"; // ou caminho absoluto se necessário
        $script = base_path("python\bet_engine.py");


        $command = [
            $pythonExecutable,
            $script,
        ];

        // Criar uma nova instância de Process
        $process = new Process($command);

        $process->setTimeout(120);        // ou 180 segundos
        // $process->setTimeout(null);    // sem timeout (cuidado em produção)

        $process->setInput(json_encode($gamesMarkets));

        $process->run();

        if (!$process->isSuccessful()) {
            dd($process->getErrorOutput());
        }

        $output = $process->getOutput();

        $decoded = json_decode($output, true);
        // $this->normalizePythonResponse($decoded);
        return $this->normalizePythonResponse($decoded) ?? [];
    }
    public function normalizePythonResponse(array $pythonResponse): array
    {
        $results = $pythonResponse['results'] ?? [];

        return [
            'safe' => $this->normalizeGroup($results['safe'] ?? []),
            'medium' => $this->normalizeGroup($results['medium'] ?? []),
            'aggressive' => $this->normalizeGroup($results['aggressive'] ?? []),
        ];
    }
    private function normalizeGroup(array $group): array
    {
        return array_map(function ($card) {

            return [
                'total_odd' => $card['total_odd'],
                'total_probability' => $card['total_probability'],

                // 🔥 transforma markets em formato limpo para Blade
                'card' => array_map(function ($leg) {
                    return [
                        'game_id' => $leg['game_id'],
                        'type' => $leg['type'],
                        'odd' => $leg['odd'],
                        'probability' => $leg['prob'],

                    ];
                }, $card['card'])
            ];
        }, $group);
    }
}
