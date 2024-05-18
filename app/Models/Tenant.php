<?php

namespace App\Models;

use App\Observers\TenantObserver;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Document;

#[ObservedBy(TenantObserver::class)]
class Tenant extends Model
{
    protected $guarded = ['id'];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return Storage::url($this->avatar);
    }

    public static function getForm(): array
    {
        return [
            Section::make('Informações da empresa')
                ->description('Dados gerais da empresa.')
                ->schema([
                    Split::make([
                        Section::make([
                            TextInput::make('name')
                                ->label('Nome')
                                ->required(),
                            Document::make('document')
                                ->label('CPF/CNPJ')
                                ->required(),
                            FileUpload::make('avatar')
                                ->label('Avatar')
                                ->acceptedFileTypes(['image/*'])
                                ->rules(['image', 'max:1024']),
                        ])->grow(false),
                    ])->from('md'),
                ]),

        ];
    }
}
