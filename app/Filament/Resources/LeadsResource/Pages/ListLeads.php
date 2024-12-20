<?php

namespace App\Filament\Resources\LeadsResource\Pages;

use App\Filament\Resources\LeadsResource;
use App\Imports\LeadsImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->label('Importar do Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->use(LeadsImport::class)
                ->uploadField(
                    fn ($upload) => $upload
                        ->label('Arquivo')
                )
                ->validateUsing([
                    'name'  => 'required',
                    'email' => 'nullable|email',
                    'phone' => ['required', 'numeric'],
                ])
                ->sampleExcel(
                    sampleData: [
                        [
                            'name'     => 'John Doe',
                            'document' => '12345678901',
                            'email'    => 'john@doe.com',
                            'phone'    => '123456789',
                        ],
                    ],
                    fileName: 'sample.xlsx',
                    sampleButtonLabel: 'Baixar exemplo',
                    customiseActionUsing: fn (Action $action) => $action->color('secondary')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->requiresConfirmation(),
                ),
            Actions\CreateAction::make()
                ->label('Novo Lead')
                ->icon('heroicon-o-plus')
                ->modal('create')
                ->slideOver()
                ->modalWidth('md'),
        ];
    }
}
