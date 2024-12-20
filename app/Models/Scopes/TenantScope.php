<?php

namespace App\Models\Scopes;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\{Builder, Model, Scope};

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('tenant_id', Filament::getTenant()->id);
    }
}
