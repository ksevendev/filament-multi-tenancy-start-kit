<?php

namespace App\Models\Business;

use App\Models\Tenant;
use Filament\Forms\Components\{Section, TextInput};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Funnel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function stages(): HasMany
    {
        return $this->hasMany(Stages::class);
    }

    public static function getForm(): array
    {
        return [
            Section::make('Informações do funil')
                ->description('Preencha as informações do funil')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->placeholder('Nome do funil')
                        ->columnSpan(['sm' => 6])
                        ->rules([
                            'required',
                            'max:255',
                        ])
                        ->validationMessages([
                            'name.required' => 'O campo nome é obrigatório',
                            'name.max'      => 'O campo nome deve ter no máximo 255 caracteres',
                        ]),
                ])->columns(2),
            Section::make('Informações dos estágios')
                ->description('Preencha as informações do estágios')
                ->schema(Stages::getForm()),
        ];
    }
}
