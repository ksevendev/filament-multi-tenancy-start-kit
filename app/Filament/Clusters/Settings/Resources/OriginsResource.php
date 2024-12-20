<?php

namespace App\Filament\Clusters\Settings\Resources;

use App\Filament\Clusters\Settings;
use App\Models\Business\Origins;
use Filament\Forms\Components\{ColorPicker, TextInput};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\Layout\{Split, Stack};
use Filament\Tables\Columns\{ColorColumn, TextColumn};
use Filament\Tables\Table;

class OriginsResource extends Resource
{
    protected static ?string $model = Origins::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Origens';

    protected static ?string $navigationGroup = 'Negócios';

    protected static ?string $cluster = Settings::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                ColorPicker::make('color')
                    ->label('Color')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    ColorColumn::make('color')
                        ->grow(false),
                    Stack::make([
                        TextColumn::make('name')
                            ->weight(FontWeight::Medium)
                            ->grow(false),
                    ]),
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index'  => \App\Filament\Clusters\Settings\Resources\OriginsResource\Pages\ListOrigins::route('/'),
            'create' => \App\Filament\Clusters\Settings\Resources\OriginsResource\Pages\CreateOrigins::route('/create'),
        ];
    }
}
