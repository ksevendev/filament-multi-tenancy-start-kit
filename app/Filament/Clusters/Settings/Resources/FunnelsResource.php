<?php

namespace App\Filament\Clusters\Settings\Resources;

use App\Filament\Clusters\Settings;
use App\Filament\Clusters\Settings\Resources\FunnelsResource\Pages\ListFunnels;
use App\Models\Business\Funnel;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FunnelsResource extends Resource
{
    protected static ?string $model = Funnel::class;

    protected static ?string $navigationIcon = 'heroicon-o-funnel';

    protected static ?string $cluster = Settings::class;

    protected static ?string $navigationGroup = 'Negócios';

    protected static ?string $label = 'Funil';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema(Funnel::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->date()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFunnels::route('/'),
        ];
    }
}
