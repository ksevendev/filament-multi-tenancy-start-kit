<?php

namespace App\Filament\Pages;

use App\Models\Business\{Business, Stages};
use Filament\Actions\{CreateAction};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class BusinessKanbanBord extends KanbanBoard
{
    protected static string $model = Business::class;

    protected static ?string $label = 'Negócios';

    protected static ?string $title = 'Negócios';

    protected static ?string $navigationGroup = 'Negócios';

    protected static string $recordStatusAttribute = 'stages_id';

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public function getTitle(): string
    {
        return 'Negócios';
    }

    protected function records(): Collection
    {
        return Business::query()
            ->with('origin', 'user', 'lead')
            ->orderByDesc('updated_at')
            ->get();

    }

    public function statuses(): Collection
    {
        return Stages::query()
            ->orderBy('order')
            ->get()
            ->map(function (Stages $stage) {
                return [
                    'id'    => $stage->id,
                    'title' => $stage->name,
                ];
            });
    }

    public function additionalRecordData(Model $record): Collection
    {
        return collect([
            'people'           => $record->lead->name,
            'value'            => $record->value,
            'closing_forecast' => $record->closing_forecast,
            'closing_date'     => $record->closing_date,
            'created'          => $record->created_at,
        ]);
    }

    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        $record = Business::findOrFail($recordId);

        $record->update([
            'stages_id' => $status,
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nova negociação')
                ->icon('heroicon-o-plus')
                ->modalHeading('Criar negociação')
                ->slideOver()
                ->modalWidth('md')
                ->form(Business::getForm())
                ->model(Business::class),
        ];
    }

    protected function getEditModalFormSchema(?int $recordId): array
    {
        return Business::getForm();
    }
}
