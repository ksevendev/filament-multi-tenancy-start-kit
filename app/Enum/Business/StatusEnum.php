<?php

namespace App\Enum\Business;

use Filament\Support\Contracts\{HasColor, HasLabel};

enum StatusEnum: string implements HasColor, HasLabel
{
    case MISSING = 'missing';

    case GAIN = 'gain';

    case RUNNING = 'running';

    case PENDING = 'pending';

    public function getLabel(): string
    {
        return match ($this) {
            self::MISSING => 'Faltando',
            self::GAIN    => 'Ganho',
            self::RUNNING => 'Em andamento',
            self::PENDING => 'Pendente',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::MISSING => 'red',
            self::GAIN    => 'green',
            self::RUNNING => 'blue',
            self::PENDING => 'yellow',
        };
    }
}
