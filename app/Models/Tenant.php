<?php

namespace App\Models;

use App\Models\Business\{Business, Lead};
use App\Observers\TenantObserver;
use Filament\Forms\Components\{FileUpload, Grid, Section, TextInput, ToggleButtons};
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany, HasMany, MorphMany};
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Support\Facades\Storage;
use Laravel\Cashier\Billable;
use Leandrocfe\FilamentPtbrFormFields\{Document};

#[ObservedBy(TenantObserver::class)]
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $avatar
 * @property string|null $document
 * @property string|null $website
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Tenant extends Model
{
    use Billable;
    use HasFactory;
    use SoftDeletes;

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

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicles::class);
    }

    public function owners(): HasMany
    {
        return $this->hasMany(Owners::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    public function calendar(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }

    public function improvementRequests(): HasMany
    {
        return $this->hasMany(ImprovementRequests::class);
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
