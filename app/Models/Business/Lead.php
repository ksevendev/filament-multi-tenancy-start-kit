<?php

namespace App\Models\Business;

use App\Models\{Tenant, User};
use Filament\Facades\Filament;
use Filament\Forms\Components\{Section, Select, TextInput};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Model, Relations\HasMany, SoftDeletes};
use Leandrocfe\FilamentPtbrFormFields\{Document, PhoneNumber};
use OwenIt\Auditing\Auditable;

class Lead extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function business(): HasMany
    {
        return $this->hasMany(Business::class);
    }

    public function origins(): BelongsTo
    {
        return $this->belongsTo(Origins::class);
    }

    public static function getForm(): array
    {
        return [
            Section::make('Informações do lead')
                ->description('Preencha as informações do lead')
                ->schema([
                    Select::make('user_id')
                        ->label('Responsável')
                        ->options(User::pluck('name', 'id'))
                        ->placeholder('Selecione um responsável')
                        ->default(auth()->id())
                        ->searchable()
                        ->required()
                        ->rules('required')
                        ->native(false),
                    Select::make('origins_id')
                        ->label('Origem')
                        ->required()
                        ->options(Origins::pluck('name', 'id'))
                        ->searchable()
                        ->createOptionForm(function () {

                            return Origins::getForm();
                        })
                        ->createOptionUsing(function (array $data): int {
                            $data['tenant_id'] = Filament::getTenant()->id;

                            return Origins::create($data)->id;
                        })
                        ->required()
                        ->native(false),
                    TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->placeholder('Nome do lead')
                        ->rules([
                            'required',
                            'max:255',
                        ]),
                    Document::make('document')
                        ->label('CPF/CNPJ'),
                    PhoneNumber::make('phone')
                        ->label('Telefone')
                        ->placeholder('Telefone do lead')
                        ->required()
                        ->rules([
                            'required',
                            'max:255',
                        ]),
                    TextInput::make('email')
                        ->label('Email')
                        ->placeholder('Email do lead')
                        ->rules([
                            'nullable',
                            'email',
                            'max:255',
                        ]),

                ]),
        ];
    }
}
