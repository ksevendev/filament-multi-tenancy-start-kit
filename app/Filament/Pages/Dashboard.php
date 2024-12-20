<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Forms\Components\{DatePicker, Section, Select};
use Filament\Forms\{Form, Get};
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    public function filtersForm(Form $form): Form
    {

        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('reponsible')
                            ->label('Responsável')
                            ->placeholder('Selecione um responsável')
                            ->options(fn () => Filament::getTenant()->users->pluck('name', 'id'))
                            ->default(fn () => auth()->id())
                            ->native(false)
                            ->searchable(),
                        DatePicker::make('startDate')
                            ->label('Data de início')
                            ->placeholder('Selecione uma data de início')
                            ->default(now()->subMonth())
                            ->native(false)
                            ->minDate(now()->subYear())
                            ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
                        DatePicker::make('endDate')
                            ->label('Data de término')
                            ->placeholder('Selecione uma data de término')
                            ->native(false)
                            ->default(now())
                            ->minDate(fn (Get $get) => $get('startDate') ?: now()->subYear())
                            ->maxDate(now()),
                    ])
                    ->columns(3),
            ]);
    }
}
