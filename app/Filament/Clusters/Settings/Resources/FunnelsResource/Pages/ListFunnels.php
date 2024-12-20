<?php

namespace App\Filament\Clusters\Settings\Resources\FunnelsResource\Pages;

use App\Filament\Clusters\Settings\Resources\FunnelsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFunnels extends ListRecords
{
    protected static string $resource = FunnelsResource::class;

    protected function getHeaderActions(): array
    {
        return [];
        //        return [
        //            Actions\CreateAction::make(),
        //        ];
    }
}
