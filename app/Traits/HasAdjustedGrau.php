<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

trait HasAdjustedGrau
{
    public function getAdjustedGrauAttribute()
    {
        return $this->calculateAdjustedGrau();
    }
    public function getGrauStatusAttribute()
    {
        return $this->getGrauStatus($this->adjusted_grau);
    }
    public function getGrauStatusColorAttribute()
    {
        return $this->getGrauStatusColor($this->adjusted_grau);
    }

    function getGrauStatus($grau)
    {
        $grau = floatval($grau);

        if ($grau === 10.0) {
            return 'EXCEPCIONAL';
        } elseif ($grau >= 9.0) {
            return 'ÓTIMO';
        } elseif ($grau >= 6.0) {
            return 'BOM';
        } elseif ($grau >= 5.0) {
            return 'REGULAR';
        } elseif ($grau >= 3.0) {
            return 'INSUFICIENTE';
        } else {
            return 'MAU';
        }
    }
    function getGrauStatusColor($nota)
    {
        $nota = floatval($nota);

        if ($nota === 10.0) {
            return 'accent';
        } elseif ($nota >= 9.0) {
            return 'success';
        } elseif ($nota >= 6.0) {
            return 'info';
        } elseif ($nota >= 5.0) {
            return 'warning';
        } elseif ($nota >= 3.0) {
            return 'error';
        } else {
            return 'error';
        }
    }

    protected function calculateAdjustedGrau(?Carbon $dataFinal = null)
    {
        $nota = floatval($this->grau);
        $dataFinal = $dataFinal ?? now();

        // Buscar punições e elogios até a dataFinal
        $punicoes = $this->fafd()
            ->whereNotNull('bi_date')
            ->where('bi_date', '<=', $dataFinal)
            ->orderBy('bi_date')
            ->get();

        $elogios = $this->compliments()
            ->whereNotNull('bi_date')
            ->where('bi_date', '<=', $dataFinal)
            ->orderBy('bi_date')
            ->get();

        Log::debug("Nota inicial: {$nota}");
        Log::debug("Data matrícula: {$this->entry_date}");
        Log::debug("Data final para cálculo: {$dataFinal->format('Y-m-d')}");

        // Montar lista única de eventos (compliment/punition) para ordenar cronologicamente
        $events = [];

        foreach ($elogios as $e) {
            // Garantir que bi_date é um Carbon
            if ($e->bi_date) {
                $events[] = [
                    'type' => 'compliment',
                    'date' => Carbon::parse($e->bi_date),
                    'model' => $e,
                ];
            }
        }

        foreach ($punicoes as $p) {
            if ($p->bi_date) {
                $events[] = [
                    'type' => 'punition',
                    'date' => Carbon::parse($p->bi_date),
                    'model' => $p,
                ];
            }
        }

        // ordenar por date asc; se mesmas datas, colocar compliments antes de punições
        usort($events, function ($a, $b) {
            if ($a['date']->eq($b['date'])) {
                // compliments first
                if ($a['type'] === $b['type']) return 0;
                return ($a['type'] === 'compliment') ? -1 : 1;
            }
            return $a['date']->lt($b['date']) ? -1 : 1;
        });

        // Se existirem punições, precisamos do primeiro para cálculo entre entry+90 e 1ª punição
        $dataReferencia = null;
        if ($punicoes->isEmpty()) {
            // Sem punições: aplicar acréscimo desde entry+90 até dataFinal (se aplicável)
            if ($this->entry_date) {
                $dataEntradaMais90 = Carbon::parse($this->entry_date)->addDays(90);
                if ($dataFinal->gt($dataEntradaMais90)) {
                    $dias = $dataEntradaMais90->diffInDays($dataFinal);
                    $incremento = $dias * 0.01;
                    $nota += $incremento;
                    $nota = min($nota, 10.00);
                    Log::debug("Sem punições. Dias após 90 da matrícula até {$dataFinal->format('Y-m-d')}: {$dias}. Aumento: {$incremento}. Nota: {$nota}");
                } else {
                    Log::debug("Sem punições. Ainda não passaram 90 dias desde a matrícula.");
                }
            }
            // Agora, mesmo sem punições, aplicar elogios que estejam na lista de eventos (eles já estão em $events)
        } else {
            // Há punições: aplicar acréscimo entre entry+90 e 1ª punição (mesmo se houver elogios nesse intervalo)
            if ($this->entry_date) {
                $primeiraPuni = Carbon::parse($punicoes->first()->bi_date);
                $dataEntradaMais90 = Carbon::parse($this->entry_date)->addDays(90);

                if ($primeiraPuni->gt($dataEntradaMais90)) {
                    $dias = $dataEntradaMais90->diffInDays($primeiraPuni);
                    $incremento = $dias * 0.01;
                    $nota += $incremento;
                    $nota = min($nota, 10.00);
                    Log::debug("Antes da 1ª punição. Dias entre 90 dias após matrícula e 1ª punição: {$dias}. Aumento: {$incremento}. Nota: {$nota}");
                } else {
                    Log::debug("Não houve tempo entre os 90 dias da matrícula e a 1ª punição para acréscimo.");
                }
            }
        }

        // Iterar todos os eventos em ordem cronológica e aplicar efeito no momento do evento
        foreach ($events as $ev) {
            if ($ev['type'] === 'compliment') {
                $e = $ev['model'];
                $grauElogio = floatval($e->grau);
                $nota += $grauElogio;
                $nota = min($nota, 10.00);
                Log::debug("Elogio em {$ev['date']->format('Y-m-d')}: +{$grauElogio}. Nota atual: {$nota}");
                // elogios NÃO alteram dataReferencia
            } else { // punition
                $p = $ev['model'];
                $dataP = $ev['date'];
                $grauPunicao = floatval($p->grau);

                if (!empty($p->dacision_days) && $p->dacision_days > 0) {
                    // regra que você tinha: para decision 'retirada_cm' multiplicar por dias; caso contrário apenas subtrair
                    if (isset($p->decision) && $p->decision === 'retirada_cm') {
                        $nota -= $grauPunicao * $p->dacision_days;
                    } else {
                        $nota -= $grauPunicao;
                    }
                } else {
                    $nota -= $grauPunicao;
                }

                $nota = max($nota, 0.00);
                Log::debug("Punição em {$dataP->format('Y-m-d')}: -{$grauPunicao}. Nota atual: {$nota}");

                // punição redefine dataReferencia (90 dias a partir da data da punição)
                $dataReferencia = $dataP->copy()->addDays(90);
                Log::debug("Nova data de referência após punição (90 dias): {$dataReferencia->format('Y-m-d')}");
            }
        }

        // Pós-última punição: aplicar acréscimo desde dataReferencia até dataFinal (se aplicável)
        if ($dataReferencia && $dataFinal->gt($dataReferencia)) {
            $dias = $dataReferencia->diffInDays($dataFinal);
            $incremento = $dias * 0.01;
            $nota += $incremento;
            $nota = min($nota, 10.00);
            Log::debug("Ajuste final após 90 dias da última punição (até {$dataFinal->format('Y-m-d')}): +{$incremento} ({$dias} dias). Nota final: {$nota}");
        } else {
            if ($dataReferencia) {
                Log::debug("Ainda não passaram 90 dias desde a última punição (referência: {$dataReferencia->format('Y-m-d')}).");
            }
        }

        return number_format($nota, 2);
    }
}
