<?php

namespace App\Observers;

use App\Models\ImprovementRequests;
use Filament\Facades\Filament;

class ImprovementRequestsObserver
{
    public function creating(ImprovementRequests $model): void
    {
        $model->tenant_id = Filament::getTenant()->id;
        $model->user_id   = Filament::auth()->id();
        $model->start     = now();
        $model->end       = now()->addDays(7);
    }
}
