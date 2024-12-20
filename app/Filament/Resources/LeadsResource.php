<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Business\Resources\LeadsResource\RelationManagers\BusinessRelationManager;
use App\Models\Business\Lead;
use Filament\Actions\RestoreAction;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\{ActionGroup, DeleteAction, EditAction, ViewAction};
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class LeadsResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Negócios';

    public static function form(Form $form): Form
    {
        return $form->schema(Lead::getForm());
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Responsável')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('document')
                    ->label('CPF/CNPJ')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefone')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('origins.name')
                    ->label('Origem')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->date()
                    ->sortable()
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
                    ExportBulkAction::make()->label('Exportar'),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->groups([
                Group::make('user.name')
                    ->label('Responsável'),
                Group::make('origins.name')
                    ->label('Origem'),
                Group::make('name')
                    ->label('Nome'),
                Group::make('phone')
                    ->label('Telefone'),
                Group::make('created_at')
                    ->label('Criado em'),
                Group::make('updated_at')
                    ->label('Atualizado em'),
            ])
            ->emptyStateIcon('heroicon-o-users')
            ->emptyStateHeading('Nenhum lead encontrado')
            ->emptyStateDescription('Crie um novo lead clicando no botão abaixo')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Criar lead')
                    ->icon('heroicon-m-plus')
                    ->modal('create')
                    ->slideOver()
                    ->modalWidth('md'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => LeadsResource\Pages\ListLeads::route('/'),
            'edit'  => LeadsResource\Pages\EditLeads::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            BusinessRelationManager::class,
            AuditsRelationManager::class,
        ];
    }
}
