<?php

namespace App\Enums;

enum UserGroups: string
{
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
    case User = 'user';

    public function badgeClass(): string
    {
        return match ($this) {
            self::SuperAdmin => 'badge-danger',
            self::Admin => 'badge-success',
            self::User => 'badge-warning',
        };
    }
    public function dbName(): string
    {
        return match ($this) {
            self::SuperAdmin => 'super_admin',
            self::Admin => 'admin',
            self::User => 'user',
        };
    }
    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Admin => 'Administração',
            self::User => 'Usuário',
        };
    }
}
