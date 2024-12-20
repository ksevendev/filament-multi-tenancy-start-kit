<?php

namespace App\Observers;

use App\Enum\Business\StatusEnum;
use App\Models\Business\Business;
use App\Models\{Calendar, User};
use Filament\Notifications\Notification;

class BusinessObserver
{
    public function creating(Business $business)
    {
        if (auth()->check()) {
            $business->tenant_id = auth()->user()->tenants->first()->id;
        }
        $business->status = StatusEnum::RUNNING;
        $business->order  = $business->tenant->businesses()->count() + 1;
        $business->active = true;
        $business->new    = true;

        if ($business->closing_forecast) {
            Calendar::create([
                'tenant_id'   => $business->tenant_id,
                'title'       => 'Previsão de fechamento de negócio',
                'user_id'     => $business->user_id,
                'start'       => $business->closing_forecast,
                'end'         => $business->closing_forecast,
                'allDay'      => true,
                'color'       => '#c7d2fe',
                'description' => "
                    **Negócio:** {$business->id}
                    **Pessoa:** {$business->lead->name}
                    **Origem:** {$business->origin->name}
                    **Valor:** {$business->value}
                    **Previsão de fechamento:** {$business->closing_forecast}
                    **Data de fechamento:** {$business->closing_date}

                ",
            ]);

            $recipient = User::query()
                ->firstWhere('id', $business->user_id);

            Notification::make()
                ->title('Saved successfully')
                ->sendToDatabase($recipient, isEventDispatched: true);

        }
    }
}
