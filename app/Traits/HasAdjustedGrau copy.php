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


        $dataReferencia = null;
        // Log::debug("Sem punições. Dias após 90 da matrícula: {$dias}. Aumento: {$incremento}. Nota final: {$nota}");
        Log::debug("Nota inicial: {$nota}");
        Log::debug("Data matricula {$this->entry_date}");

        if ($punicoes->isEmpty()) {
            if ($this->entry_date) {
                $dataReferencia = Carbon::parse($this->entry_date)->addDays(90);
                if (now()->gt($dataReferencia)) {
                    $dias = $dataReferencia->diffInDays(now());
                    $incremento = $dias * 0.01;
                    $nota += $incremento;
                    $nota = min($nota, 10.00);
                    Log::debug("Sem punições. Dias após 90 da matrícula: {$dias}. Aumento: {$incremento}. Nota final: {$nota}");
                } else {
                    Log::debug("Sem punições. Ainda não passaram 90 dias desde a matrícula.");
                }
                // 🔥 Adiciona elogios (independente de punição)
                foreach ($elogios as $e) {
                    $grauElogio = floatval($e->grau);
                    $nota += $grauElogio;
                    $nota = min($nota, 10.00);
                    Log::debug("Elogio em {$e->bi_date}: +{$grauElogio}. Nota atual: {$nota}");
                }
            }
            return number_format($nota, 2);
        }

        // ✅ Ajuste adicional ANTES da primeira punição
        $primeiraPunição = Carbon::parse($punicoes->first()->bi_date);
        Log::debug("Data 1ª {$primeiraPunição}");

        $dataEntradaMais90 = Carbon::parse($this->entry_date)->addDays(90);
        Log::debug("Data 1ª {$dataEntradaMais90}");
        if ($this->entry_date) {
            $dataEntradaMais90 = Carbon::parse($this->entry_date)->addDays(90);

            if ($primeiraPunição->gt($dataEntradaMais90)) {
                $dias = $dataEntradaMais90->diffInDays($primeiraPunição);
                $incremento = $dias * 0.01;
                $nota += $incremento;
                $nota = min($nota, 10.00);
                Log::debug("Antes da 1ª punição. Dias entre 90 dias após matrícula e 1ª punição: {$dias}. Aumento: {$incremento}. Nota atual: {$nota}");
            } else {
                Log::debug("Não houve tempo entre os 90 dias da matrícula e a 1ª punição para acréscimo.");
            }
        }

        // Aplica punições
        foreach ($punicoes as $p) {
            $dataP = Carbon::parse($p->bi_date);
            $grauPunicao = floatval($p->grau);

            // $nota -= $grauPunicao * $p->dacision_days;
            if ($p->dacision_days > 0 and $p->dacision_days) {

                if ($p->decision == 'retirada_cm'){
                    $nota -= $grauPunicao * $p->dacision_days;
                }else{
                    $nota -= $grauPunicao;
                }
            } else {

                $nota -= $grauPunicao;
            }

            $nota = max($nota, 0.00);

            Log::debug("Punição em {$p->bi_date}: -{$grauPunicao}. Nota atual: {$nota}");

            // Atualiza data referência para o último castigo
            $dataReferencia = $dataP->copy()->addDays(90);
            Log::debug("Nova data de referência após punição (90 dias): {$dataReferencia->format('Y-m-d')}");
        }

        // Ajuste final se já passaram 180 dias da última punição
        if ($dataReferencia && now()->gt($dataReferencia)) {
            $dias = $dataReferencia->diffInDays(now());
            $incremento = $dias * 0.01;
            $nota += $incremento;
            $nota = min($nota, 10.00);

            Log::debug("Ajuste final após 90 dias da última punição: +{$incremento} ({$dias} dias). Nota final: {$nota}");
        } else {
            Log::debug("Ainda não passaram 90 dias desde a última punição.");
        }

        // 🔥 Adiciona elogios (independente de punição)
        foreach ($elogios as $e) {
            $grauElogio = floatval($e->grau);
            $nota += $grauElogio;
            $nota = min($nota, 10.00);
            Log::debug("Elogio em {$e->bi_date}: +{$grauElogio}. Nota atual: {$nota}");
        }


        return number_format($nota, 2);
    }
}
