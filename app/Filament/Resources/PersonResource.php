<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonResource\Pages;
use App\Models\Person;
use Filament\Actions\RestoreAction;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\{Action, ActionGroup, DeleteAction, EditAction, ViewAction};
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class PersonResource extends Resource
{
    protected static ?int $navigationSort = 1;

    protected static ?string $model = Person::class;

    protected static ?string $label = 'Clientes';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema(Person::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->description(fn ($record) => $record->document)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('surname')
                    ->label('Apelido')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('birth_date')
                    ->label('Data de nascimento')
                    ->date()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('nationality')
                    ->label('Nacionalidade')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('naturalness')
                    ->label('Naturalidade')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('profession')
                    ->label('Profissão')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    RestoreAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make()->label('Exportar para Excel'),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateIcon('heroicon-o-users')
            ->emptyStateHeading('Nenhuma pessoa encontrada')
            ->emptyStateDescription('Crie uma nova pessoa clicando no botão abaixo')
            ->emptyStateActions([
                Action::make('create')
                    ->label('Criar pessoa')
                    ->icon('heroicon-m-plus')
                    ->url('people/create'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPeople::route('/'),
            'create' => Pages\CreatePerson::route('/create'),
            'edit'   => Pages\EditPerson::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            AuditsRelationManager::class,
        ];
    }
}
