<?php

namespace App\Models;

use App\Observers\TenantObserver;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
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

    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Addresses::class, 'addressable');
    }

    public function phones(): MorphMany
    {
        return $this->morphMany(Phones::class, 'phonable');
    }

    public function emails(): MorphMany
    {
        return $this->morphMany(Emails::class, 'emailable');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return Storage::url($this->avatar);
    }

    public static function getForm(): array
    {
        return [
            Section::make('Informações da conta')
                ->icon('heroicon-o-information-circle')
                ->description('Gerencie as informações da sua conta')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->placeholder('Nome da empresa'),
                    Document::make('document')
                        ->label('CPF/CNPJ')
                        ->placeholder('CPF/CNPJ da empresa'),
                    ToggleButtons::make('type')
                        ->label('Tipo')
                        ->inline()
                        ->grouped()
                        ->options([
                            'vehicle' => 'Veículo',
                            'other'   => 'Outro',
                        ])
                        ->icons([
                            'vehicle' => 'heroicon-o-truck',
                            'other'   => 'heroicon-o-user',
                        ])
                        ->required(),
                    TextInput::make('website')
                        ->prefix('https://')
                        ->label('Site'),
                    FileUpload::make('avatar')
                        ->label('Avatar')
                        ->acceptedFileTypes(['image/*'])
                        ->rules(['image', 'max:1024'])
                        ->directory('avatars')
                        ->downloadable()
                        ->previewable(false),
                ])
                ->columns(),
            Section::make('Contatos')
                ->icon('heroicon-o-phone')
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
                ->icon('heroicon-o-globe-americas')
                ->description('Insira os dados pessoais do cliente')
                ->schema([
                    Grid::make(2)
                        ->schema(Addresses::getForm())
                        ->columnSpan(2),
                ])
                ->grow(true),
        ];
    }
}
