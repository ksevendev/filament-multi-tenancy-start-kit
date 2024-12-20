<?php

namespace App\Filament\Resources\ImprovementRequestsResource\Pages;

use App\Filament\Resources\ImprovementRequestsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListImprovementRequests extends ListRecords
{
    protected static string $resource = ImprovementRequestsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Todos')
                ->icon('heroicon-o-rectangle-stack'),
            'pending' => Tab::make('Pendentes')
                ->icon('heroicon-o-clock')
                ->query(fn ($query) => $query->where('status', 'pending')),
            'approved' => Tab::make('Aprovadas')
                ->icon('heroicon-o-check-circle')
                ->query(fn ($query) => $query->where('status', 'approved')),
            'rejected' => Tab::make('Rejeitadas')
                ->icon('heroicon-o-x-circle')
                ->query(fn ($query) => $query->where('status', 'rejected')),
            'running' => Tab::make('Em andamento')
                ->icon('heroicon-o-play')
                ->query(fn ($query) => $query->where('status', 'running')),
            'completed' => Tab::make('Concluídas')
                ->icon('heroicon-o-check-circle')
                ->query(fn ($query) => $query->where('status', 'completed')),

        ];
    }
}
