<?php

namespace App\Filament\Widgets;

use App\Models\Calendar;
use Filament\Facades\Filament;
use Saade\FilamentFullCalendar\Actions\CreateAction;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public string|null|\Illuminate\Database\Eloquent\Model $model = Calendar::class;

    protected static ?int $sort = 5;

    public function config(): array
    {
        return [
            'firstDay'      => 1,
            'headerToolbar' => [
                'left'   => 'dayGridWeek,dayGridDay',
                'center' => 'title',
                'right'  => 'prev,next today',
            ],
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Calendar::query()
            ->where([
                ['user_id', auth()->id()],
                ['tenant_id', Filament::getTenant()->id],
            ])
            ->get()
            ->map(function (Calendar $calendar) {
                return [
                    'id'          => $calendar->id,
                    'title'       => $calendar->title,
                    'description' => $calendar->description,
                    'start'       => $calendar->start,
                    'end'         => $calendar->end,
                    'allDay'      => $calendar->allDay,
                    'color'       => $calendar->color,
                ];
            })
            ->toArray();
    }

    public function getFormSchema(): array
    {
        return Calendar::getForm();
    }

    protected function headerActions(): array
    {
        return [
            CreateAction::make()
                ->label('Novo atividade')
                ->icon('heroicon-o-plus')
                ->color('gray')
                ->slideOver()
                ->modalWidth('md'),

        ];
    }
}
