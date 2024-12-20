<?php

namespace App\Observers;

use App\Models\Calendar;
use Filament\Facades\Filament;

class CalendarObserver
{
    public function creating(Calendar $calendar)
    {
        if (auth()->check()) {
            $calendar->tenant_id = Filament::getTenant()->id;
        }

    }
}
