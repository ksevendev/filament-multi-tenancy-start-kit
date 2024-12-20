<?php

namespace App\Models\Business;

use App\Models\Scopes\TenantScope;
use Filament\Forms\Components\{Repeater, TextInput};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy(TenantScope::class)]
class Stages extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }

    public static function getForm(): array
    {
        return [
            Repeater::make('stages')
                ->label('Estágios')
                ->relationship()
                ->simple(
                    TextInput::make('name')
                        ->label('Nome')
                        ->rules('required')
                )
                ->cloneable()
                ->reorderableWithButtons()
                ->defaultItems(2),
        ];
    }
}
