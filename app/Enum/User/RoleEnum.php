<?php

namespace App\Enum\User;

use Filament\Support\Contracts\{HasIcon, HasLabel};

enum RoleEnum: string implements HasIcon, HasLabel
{
    case Admin = 'admin';
    case User  = 'user';

    public function getIcon(): string
    {
        return match ($this) {
            self::Admin => 'heroicon-o-shield-check',
            self::User  => 'heroicon-o-user',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::User  => 'Usuário',
        };
    }
}
