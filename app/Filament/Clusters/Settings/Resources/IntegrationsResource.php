<?php

namespace App\Filament\Clusters\Settings\Resources;

use App\Filament\Clusters\Settings;
use App\Models\Integrations;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\{Forms, Tables};
use Novadaemon\FilamentPrettyJson\PrettyJson;

class IntegrationsResource extends Resource
{
    protected static ?string $cluster = Settings::class;

    protected static ?string $model = Integrations::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $label = 'Integrações';

    protected static ?string $navigationGroup = 'Integrações';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nome'),
            Forms\Components\TextInput::make('url')
                ->label('URL'),
            Forms\Components\TextInput::make('api_key')
                ->label('Chave de API'),
            Forms\Components\TextInput::make('api_token')
                ->label('Token de API'),
            PrettyJson::make('settings')
                ->label('Configurações'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->searchable(),
                Tables\Columns\TextColumn::make('api_key')
                    ->label('Chave de API')
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->label('Ativo'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-o-eye')
                    ->label(''),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Clusters\Settings\Resources\IntegrationsResource\Pages\ListIntegrations::route('/'),
        ];
    }
}
