<?php

namespace App\Filament\Clusters\Settings\Resources;

use App\Filament\Clusters\Settings;
use App\Filament\Clusters\Settings\Resources\UsersResource\Pages;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\Layout\{Split, Stack};
use Filament\Tables\Columns\{ImageColumn, TextColumn};
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class UsersResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $label = 'Usuários';

    protected static ?string $navigationGroup = 'Empresa';

    protected static ?string $cluster = Settings::class;

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->id === 1) {
            return $query;
        }

        return $query->whereKeyNot(1);
    }

    public static function form(Form $form): Form
    {
        return $form->schema(User::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    ImageColumn::make('avatar')
                        ->circular()
                        ->grow(false),

                    Stack::make([
                        TextColumn::make('name')
                            ->weight(FontWeight::Bold)
                            ->grow(false),
                        TextColumn::make('role')
                            ->grow(false),
                    ]),
                    Stack::make([
                        TextColumn::make('phone')
                            ->icon('heroicon-m-phone')
                            ->grow(false),
                        TextColumn::make('email')
                            ->icon('heroicon-m-envelope')
                            ->grow(false),
                    ]),
                    Stack::make([
                        TextColumn::make('created_at')
                            ->label('Criado em')
                            ->icon('heroicon-o-calendar')
                            ->date()
                            ->dateTooltip(),
                        TextColumn::make('updated_at')
                            ->label('Atualizado em')
                            ->icon('heroicon-o-arrow-path')
                            ->date()
                            ->dateTooltip(),
                    ]),
                ]),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()
                    ->label('Exportar'),
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUsers::route('/create'),
            'edit'   => Pages\EditUsers::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            AuditsRelationManager::class,
        ];
    }
}
