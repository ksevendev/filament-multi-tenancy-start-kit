<?php

namespace App\Models;

use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $emailable_type
 * @property int $emailable_id
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Emails extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address',
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
            TableRepeater::make('emails')
                ->relationship('emails')
                ->label('')
                ->headers([
                    Header::make('email')
                        ->label('E-mails'),
                ])
                ->schema([
                    TextInput::make('address')
                        ->label('E-mail')
                        ->nullable()
                        ->email(),
                ])
                ->default([])
                ->columnSpan('full')
                ->emptyLabel('Nenhum e-mail cadastrado')
                ->addActionLabel('Adicionar e-mail'),
        ];
    }
}
