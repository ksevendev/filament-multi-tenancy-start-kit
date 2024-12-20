<?php

namespace App\Filament\Clusters\Settings\Resources\FunnelsResource\Pages;

use App\Filament\Clusters\Settings\Resources\FunnelsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFunnels extends EditRecord
{
    protected static string $resource = FunnelsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
