<?php

namespace App\Models;

use App\Observers\CalendarObserver;
use Filament\Forms\Components\{ColorPicker, DatePicker, MarkdownEditor, Select, TextInput, Toggle};
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(CalendarObserver::class)]
class Calendar extends Model
{
    /** @use HasFactory<\Database\Factories\CalendarFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public static function getForm(): array
    {
        return [
            TextInput::make('title')
                ->label('Título')
                ->rules('required'),
            Select::make('user_id')
                ->label('Responsável')
                ->options(fn () => User::pluck('name', 'id'))
                ->default(fn () => auth()->id())
                ->native(false)
                ->searchable()
                ->required(),
            DatePicker::make('start')
                ->label('Início')
                ->required(),
            DatePicker::make('end')
                ->label('Fim')
                ->required(),
            // all day
            Toggle::make('allDay')
                ->label('Dia inteiro')
                ->default(false),
            ColorPicker::make('color')
                ->label('Cor')
                ->default('#000000'),
            MarkdownEditor::make('description')
                ->label('Descrição'),
        ];
    }
}
