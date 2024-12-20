<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Settings extends Cluster
{
    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $title = 'Configurações';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

}
