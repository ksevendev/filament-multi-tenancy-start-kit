<?php

namespace App\Enum\ImprovementRequests;

use Filament\Support\Contracts\{HasColor, HasLabel};

enum TypeImprovementsEnum: string implements HasColor, HasLabel
{
    case IMPROVEMENT = 'improvement';

    case BUG = 'bug';

    case FEATURE = 'feature';

    public function getLabel(): string
    {
        return match ($this) {
            self::IMPROVEMENT => 'Melhoria',
            self::BUG         => 'Bug',
            self::FEATURE     => 'Funcionalidade',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::IMPROVEMENT => 'success',
            self::BUG         => 'danger',
            self::FEATURE     => 'primary',
        };
    }

}
