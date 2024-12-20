<?php

namespace App\Filament\Clusters\Business\Resources\LeadsResource\RelationManagers;

use App\Models\Business\{Business, Stages};
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\{Actions\RestoreAction,
    Forms\Components\DatePicker,
    Tables,
    Tables\Actions\ActionGroup,
    Tables\Actions\DeleteAction,
    Tables\Actions\EditAction,
    Tables\Actions\ViewAction,
    Tables\Filters\Filter,
    Tables\Grouping\Group};
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class BusinessRelationManager extends RelationManager
{
    protected static string $relationship = 'business';

    protected static ?string $label = 'Negócios';

    protected static ?string $title = 'Negócios';

    protected static ?string $icon = 'heroicon-o-currency-dollar';

    protected static ?string $model = Business::class;

    public function form(Form $form): Form
    {
        return $form->schema(Business::getForm());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Business')
            ->columns([
                Tables\Columns\TextColumn::make('origin.name')
                    ->label('Origem')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stages.name')
                    ->label('Estágio')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('valuation')
                    ->label('Valor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('closing_forecast')
                    ->label('Previsão de fechamento')
                    ->date()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('closing_date')
                    ->label('Data de fechamento')
                    ->date()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'gain'    => 'Ganho',
                        'running' => 'Em andamento',
                        'pending' => 'Pendente',
                        'missing' => 'Faltando',
                    ]),
                Tables\Filters\SelectFilter::make('stages.id')
                    ->label('Estágio')
                    ->options(fn () => Stages::pluck('name', 'id')->toArray()),
                Filter::make('closing_forecast')
                    ->form([
                        DatePicker::make('closing_forecast')
                            ->label('Previsão de fechamento')
                            ->placeholder('Selecione uma data')
                            ->format('DD/MM/YYYY'),

                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
                Group::make('origin.name')
                    ->label('Origem'),
                Group::make('status')
                    ->label('Status'),
                Group::make('stages.name')
                    ->label('Estágio'),
            ])
            ->emptyStateIcon('heroicon-o-currency-dollar')
            ->emptyStateHeading('Nenhum negócio encontrado')
            ->emptyStateDescription('Crie um novo negócio para começar a gerenciar seus leads.');
    }
}
