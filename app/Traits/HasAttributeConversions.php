<?php

namespace App\Traits;

use Carbon\Carbon;

trait HasAttributeConversions
{
    public function dbValue($value)
    {
        // Verifica se o valor já está no formato correto (número com ponto e duas casas decimais)
        if (preg_match('/^\d+(\.\d{2})?$/', $value)) {
            // Se já estiver no formato correto, apenas atribui o valor diretamente
            return $value;
        }
        // Caso contrário, aplicamos a formatação correta
        // Remove o ponto que representa separador de milhares
        $cleanedValue = str_replace('.', '', $value);
        // Substitui a vírgula decimal por ponto
        $cleanedValue = str_replace(',', '.', $cleanedValue);
        // Verifica se o valor é numérico
        if (is_numeric($cleanedValue)) {
            // Converte o valor para float e mantém o valor com 2 casas decimais
            $formattedValue = number_format((float)$cleanedValue, 2, '.', '');
            // Define o valor formatado no atributo
            return $formattedValue;
        } else {
            // Define o valor como 0 ou lança uma exceção
            return 0;
        }
    }
    public function viewValue($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function dbDate($value)
    {
        if ($value != "") {
            return implode("-", array_reverse(explode("/", $value)));
        } else {
            return NULL;
        }
    }
    public function viewDate($value)
    {
        if ($value != "") {
            return Carbon::createFromFormat('Y-m-d', $value)
                ->format('d/m/Y');
        }
    }

    public function viewDateHour($value)
    {
        if ($value != "") {
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)
                ->format('d/m/Y H:i');
        }
    }
    public function dbDateHour($value)
    {
        if ($value != "") {
            $d = explode(' ', $value);
            $h = explode(':', $d[1]);
            return implode("-", array_reverse(explode("/", $d[0]))) . ' ' . $h[0] . ':' . $h[1];
        } else {
            return NULL;
        }
    }
}
