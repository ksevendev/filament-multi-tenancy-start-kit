<?php

namespace App\Models\Business;

use App\Enum\Business\StatusEnum;
use App\Filament\Components\PtbrMoney;
use App\Models\{Observations, Tenant, User, Vehicles};
use App\Observers\BusinessObserver;
use Filament\Facades\Filament;
use Filament\Forms\Components\{DatePicker, Section, Select, TextInput};
use Filament\Forms\{Get, Set};
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(BusinessObserver::class)]
class Business extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status'           => StatusEnum::class,
        'closing_forecast' => 'datetime',
        'closing_date'     => 'datetime',
        'last_at'          => 'datetime',
        'new'              => 'boolean',
        'vehicles'         => 'array',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function stages(): BelongsTo
    {
        return $this->belongsTo(Stages::class, 'stages_id');
    }

    public function origin(): BelongsTo
    {
        return $this->belongsTo(Origins::class, 'origins_id');
    }

    public function observations(): BelongsTo
    {
        return $this->belongsTo(Observations::class);
    }

    public static function getForm(): array
    {
        return [
            Section::make('Lead')
                ->description('Informações sobre a pessoa que está interessada no negócio')
                ->icon('heroicon-o-user')
                ->schema([
                    Select::make('lead_id')
                        ->label('Pessoa')
                        ->options(Lead::pluck('name', 'id'))
                        ->searchable()
                        ->rules('required')
                        ->createOptionForm(function () {
                            return Lead::getForm();
                        })
                        ->createOptionUsing(function (array $data): int {
                            $data['tenant_id'] = Filament::getTenant()->id;

                            return Lead::create($data)->id;
                        })
                        ->native(false)
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            $lead = Lead::find($get('lead_id'));

                            $set('name', 'Negócio com ' . $lead?->name);
                        })
                        ->preload(),
                    Select::make('origins_id')
                        ->label('Origem')
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
                ]),
            Section::make('Negociação')
                ->description('Dados da negociação')
                ->icon('heroicon-o-currency-dollar')
                ->schema([
                    TextInput::make('name')
                        ->label('Título'),
                    PtbrMoney::make('valuation')
                        ->label('Valor')
                        ->rules('required'),
                    Select::make('stages_id')
                        ->label('Estágio')
                        ->options(Stages::pluck('name', 'id'))
                        ->default(Stages::query()->first()->id)
                        ->reactive()
                        ->rules('required')
                        ->native(false),
                    Select::make('user_id')
                        ->label('Responsável')
                        ->options(User::pluck('name', 'id'))
                        ->placeholder('Selecione um responsável')
                        ->default(auth()->id())
                        ->searchable()
                        ->rules('required')
                        ->native(false),
                    DatePicker::make('closing_forecast')
                        ->label('Previsão de fechamento')
                        ->native(false),
                ]),
        ];
    }
}
