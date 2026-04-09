<?php

namespace App\Enums;

enum TypePeople: int
{
        // case SuperAdmin = 'super_admin';
    case Estudante = 1;
    case Monitor = 2;
    case Sargenteante = 3;
    case Comandante_cia = 4;
    case Comandante_ca = 5;
    case Comandante_colegio = 6;

    public function badgeClass(): string
    {
        return match ($this) {
            self::Estudante => 'badge-success',
            self::Monitor => 'badge-warning',
            self::Sargenteante => 'badge-warning',
            self::Comandante_cia => 'badge-warning',
            self::Comandante_ca => 'badge-warning',
            self::Comandante_colegio => 'badge-warning',
        };
    }
    public function dbName(): string
    {
        return match ($this) {
            self::Estudante => 'Estudante',
            self::Monitor => 'Monitor',
            self::Sargenteante => 'Sargenteante',
            self::Comandante_cia => 'Comandante da Cia',
            self::Comandante_ca => 'Comandante do CA',
            self::Comandante_colegio => 'Comandante do colégio',
        };
    }
}
