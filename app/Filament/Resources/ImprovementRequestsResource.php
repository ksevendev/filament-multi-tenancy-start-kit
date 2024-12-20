<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImprovementRequestsResource\Pages;
use App\Models\ImprovementRequests;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\{ActionGroup,
    BulkActionGroup,
    CreateAction,
    DeleteAction,
    DeleteBulkAction,
    EditAction,
    ForceDeleteBulkAction,
    RestoreBulkAction
};
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\{Builder, SoftDeletingScope};
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ImprovementRequestsResource extends Resource
{
    protected static ?string $model = ImprovementRequests::class;

    protected static ?string $slug = 'improvement-requests';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $label = 'Solicitações';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema(ImprovementRequests::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Usuário')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('start')
                    ->label('Início')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('end')
                    ->label('Fim')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->groups([
                Group::make('user.name')
                    ->label('Usuário'),
                Group::make('status')
                    ->label('Status'),
                Group::make('type')
                    ->label('Tipo'),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()->label('Exportar'),
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateIcon('heroicon-o-document-text')
            ->emptyStateHeading('Nenhuma solicitação de melhoria encontrada')
            ->emptyStateDescription('Crie uma nova solicitação de melhoria clicando no botão abaixo')
            ->emptyStateActions([
                CreateAction::make()
                    ->label('Criar solicitação de melhoria')
                    ->icon('heroicon-m-plus')
                    ->modal('create')
                    ->slideOver()
                    ->modalWidth('md'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListImprovementRequests::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
