<?php

namespace App\Enums;

enum StatusFo: int
{
    case LancarFafd = 1;
    case Aguardando = 2;


    public function label(): string
    {
        return match ($this) {
            self::LancarFafd => 'Ser aluno matriculado com menos de 03 (três) meses',
            self::Aguardando => 'Ser por sua idade considerado criança ou adolescente',
        };
    }
}
