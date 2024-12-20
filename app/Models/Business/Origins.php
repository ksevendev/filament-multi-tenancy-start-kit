<?php

namespace App\Models\Business;

use App\Models\Tenant;
use Filament\Forms\Components\{ColorPicker, TextInput};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Origins extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->label('Name')
                ->required(),
            ColorPicker::make('color')
                ->label('Color')
                ->required(),
        ];
    }
}
