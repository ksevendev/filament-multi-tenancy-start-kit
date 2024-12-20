<?php

namespace App\Models;

use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

/**
 * @property int $id
 * @property string $phonable_type
 * @property int $phonable_id
 * @property string $number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Phones extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
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
            TableRepeater::make('phones')
                ->relationship('phones')
                ->label('')
                ->headers([
                    Header::make('phone')
                        ->label('Telefones'),
                ])
                ->schema([
                    PhoneNumber::make('number')
                        ->label('Telefone')
                        ->default(null),
                ])
                ->default([])
                ->columnSpan('full')
                ->emptyLabel('Nenhum telefone cadastrado'),
        ];
    }
}
