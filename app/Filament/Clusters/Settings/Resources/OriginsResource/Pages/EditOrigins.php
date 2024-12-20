<?php

namespace App\Filament\Clusters\Settings\Resources\OriginsResource\Pages;

use App\Filament\Clusters\Settings\Resources\OriginsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrigins extends EditRecord
{
    protected static string $resource = OriginsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
