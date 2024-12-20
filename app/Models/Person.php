<?php

namespace App\Models;

use Filament\Forms;
use Filament\Forms\Components\{Grid, Section, Split};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphMany};
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Leandrocfe\FilamentPtbrFormFields\Document;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property int $id
 * @property int $tenant_id
 * @property string $name
 * @property string $type
 * @property string|null $surname
 * @property string|null $document
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string|null $nationality
 * @property string|null $naturalness
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Tenant $tenant
 */
class Person extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function phones(): MorphMany
    {
        return $this->morphMany(Phones::class, 'phonable');
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Addresses::class, 'addressable');
    }

    public function emails(): MorphMany
    {
        return $this->morphMany(Emails::class, 'emailable');
    }

    public static function getForm(): array
    {
        return [
            Split::make([
                Section::make('Dados pessoais')
                    ->description('Insira os dados pessoais do cliente')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->rules([
                                'required',
                                'max:50',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('surname')
                            ->label('Apelido')
                            ->rules([
                                'nullable',
                                'max:50',
                            ]),
                        Document::make('document')
                            ->label('CPF/CNPJ')
                            ->dynamic(),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Data de nascimento')
                            ->native()
                            ->rules([
                                'nullable',
                                'date',
                                'before:today',
                            ]),
                        Forms\Components\TextInput::make('nationality')
                            ->label('Nacionalidade')
                            ->rules([
                                'nullable',
                                'max:50',
                            ]),
                        Forms\Components\TextInput::make('naturalness')
                            ->label('Naturalidade')
                            ->rules([
                                'nullable',
                                'max:50',
                            ]),
                        Forms\Components\TextInput::make('profession')
                            ->label('Profissão')
                            ->rules([
                                'nullable',
                                'max:50',
                            ]),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->grow(true),
                Section::make('Contatos')
                    ->description('Insira os dados pessoais do cliente')
                    ->schema([
                        Grid::make(2)
                            ->schema(Phones::getForm())
                            ->columnSpan(1),
                        Grid::make(2)
                            ->schema(Emails::getForm())
                            ->columnSpan(1),
                    ])
                    ->grow(true)
                    ->columns(2),
                Section::make('Endereços')
                    ->description('Insira os dados pessoais do cliente')
                    ->schema([
                        Grid::make(2)
                            ->schema(Addresses::getForm())
                            ->columnSpan(2),
                    ])
                    ->grow(true),
            ])
                ->columnSpan(2)
                ->from('2xl'),

        ];
    }
}
