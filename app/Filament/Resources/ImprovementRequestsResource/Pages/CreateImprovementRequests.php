<?php

namespace App\Filament\Resources\ImprovementRequestsResource\Pages;

use App\Filament\Resources\ImprovementRequestsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateImprovementRequests extends CreateRecord
{
    protected static string $resource = ImprovementRequestsResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
