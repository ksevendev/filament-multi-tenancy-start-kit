<?php

namespace App\Enum\ImprovementRequests;

use Filament\Support\Contracts\{HasColor, HasLabel};

enum StatusImprovementsEnum: string implements HasColor, HasLabel
{
    case PENDING   = 'pending';
    case APPROVED  = 'approved';
    case REJECTED  = 'rejected';
    case COMPLETED = 'completed';
    case RUNNING   = 'running';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING   => 'Pendente',
            self::APPROVED  => 'Aprovada',
            self::REJECTED  => 'Rejeitada',
            self::COMPLETED => 'Concluída',
            self::RUNNING   => 'Em andamento',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING   => 'warning',
            self::APPROVED  => 'success',
            self::REJECTED  => 'danger',
            self::COMPLETED => 'info',
            self::RUNNING   => 'primary',
        };
    }
}
