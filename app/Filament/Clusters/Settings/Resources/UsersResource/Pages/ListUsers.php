<?php

namespace App\Filament\Clusters\Settings\Resources\UsersResource\Pages;

use App\Filament\Clusters\Settings\Resources\UsersResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UsersResource::class;

    protected function getHeaderActions(): array
    {
        $tenant = Filament::getTenant();

        return [
            Actions\CreateAction::make()
                ->label('Novo usuário')
                ->icon('heroicon-o-plus')
                ->visible(fn () => count($tenant->members) <= 3),
        ];
    }
}
