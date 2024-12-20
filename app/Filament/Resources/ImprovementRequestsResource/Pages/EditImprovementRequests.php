<?php

namespace App\Filament\Resources\ImprovementRequestsResource\Pages;

use App\Filament\Resources\ImprovementRequestsResource;
use Filament\Actions\{DeleteAction, ForceDeleteAction, RestoreAction};
use Filament\Resources\Pages\EditRecord;

class EditImprovementRequests extends EditRecord
{
    protected static string $resource = ImprovementRequestsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
