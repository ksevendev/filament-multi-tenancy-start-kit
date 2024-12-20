<?php

namespace App\Models;

use Filament\Forms\Components\{Repeater, TextInput};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Leandrocfe\FilamentPtbrFormFields\Cep;

/**
 * @property int $id
 * @property string $addressable_type
 * @property int $addressable_id
 * @property string $postal_code
 * @property string $street
 * @property string|null $number
 * @property string|null $complement
 * @property string $district
 * @property string $city
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Addresses extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'postal_code',
        'morphs',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public static function getForm(): array
    {
        return [
            Repeater::make('addresses')
                ->label('Endereços')
                ->relationship()
                ->schema([
                    Cep::make('postal_code')
                        ->label('CEP')
                        ->live(onBlur: true)
                        ->viaCep(
                            mode: 'suffix',
                            errorMessage: 'CEP inválido.',
                            setFields: [
                                'street'     => 'logradouro',
                                'number'     => 'numero',
                                'complement' => 'complemento',
                                'district'   => 'bairro',
                                'city'       => 'localidade',
                                'state'      => 'uf',
                            ]
                        )
                        ->required()
                        ->columnSpan(2),
                    TextInput::make('street')
                        ->label('Rua')
                        ->required(),
                    TextInput::make('number')
                        ->label('Número')
                        ->required(),
                    TextInput::make('complement')
                        ->label('Complemento'),
                    TextInput::make('district')
                        ->label('Bairro')
                        ->required(),
                    TextInput::make('city')
                        ->label('Cidade')
                        ->required(),
                    TextInput::make('state')
                        ->label('Estado')
                        ->required(),
                ])
                ->columns(2)
                ->addActionLabel('Adicionar endereço')
                ->collapsible()
                ->cloneable()
                ->itemLabel(fn (array $state): ?string => $state['street'] . ', ' . $state['number']),
        ];
    }
}
