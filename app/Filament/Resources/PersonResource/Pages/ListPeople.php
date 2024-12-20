<?php

namespace App\Filament\Resources\PersonResource\Pages;

use App\Filament\Resources\PersonResource;
use App\Imports\{PeopleImport};
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListPeople extends ListRecords
{
    protected static string $resource = PersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->label('Importar do Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->use(PeopleImport::class)
                ->uploadField(
                    fn ($upload) => $upload
                        ->label('Arquivo')
                )
                ->validateUsing([
                    'name'       => 'required',
                    'birth_date' => 'nullable|date',
                ])
                ->sampleExcel(
                    sampleData: [
                        [
                            'name'        => 'John',
                            'surname'     => 'Doe',
                            'document'    => '12345678900',
                            'birth_date'  => '1990-01-01',
                            'nationality' => 'Brasileiro',
                            'naturalness' => 'São Paulo',
                            'profession'  => 'Developer',
                        ],
                    ],
                    fileName: 'sample.xlsx',
                    sampleButtonLabel: 'Baixar exemplo',
                    customiseActionUsing: fn (Action $action) => $action->color('secondary')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->requiresConfirmation(),
                ),
            Actions\CreateAction::make()
                ->label('Novo cliente')
                ->icon('heroicon-o-plus'),
        ];
    }
}
