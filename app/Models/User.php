<?php

namespace App\Models;

use App\Enum\User\RoleEnum;
use Filament\Facades\Filament;
use Filament\Forms\Components\{FileUpload, Section, ToggleButtons};
use Filament\Models\Contracts\{FilamentUser, HasAvatar, HasTenants};
use Filament\{Forms, Panel};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;
use OwenIt\Auditing\Contracts\{Auditable};

/**
 * @property int $id
 * @property string|null $avatar
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class User extends Authenticatable implements Auditable, FilamentUser, HasAvatar, HasTenants
{
    use HasFactory, Notifiable, \OwenIt\Auditing\Auditable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'avatar',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'role'              => RoleEnum::class,
    ];

    public function getTenants(Panel $panel): Collection
    {
        return $this->tenants;
    }

    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class);
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->tenants->contains($tenant);
    }

    public function tenant(): BelongsToMany
    {
        return $this->tenants()->where('tenant_id', Filament::getTenant()->getAttribute('id'));
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar ? Storage::url($this->avatar) : null;
    }

    public static function getForm(): array
    {
        return [
            Section::make('Informações do usuário')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->rules(['required']),
                    Forms\Components\TextInput::make('email')
                        ->label('E-mail')
                        ->rules(['required', 'email']),
                    PhoneNumber::make('phone')
                        ->label('Telefone')
                        ->default(null),
                    ToggleButtons::make('role')
                        ->label('Função')
                        ->options([
                            'admin' => 'Administrador',
                            'user'  => 'Usuário',
                        ])
                        ->icons([
                            'admin' => 'heroicon-o-shield-check',
                            'user'  => 'heroicon-o-user',
                        ])
                        ->inline(),
                    Forms\Components\TextInput::make('password')
                        ->label('Senha')
                        ->password()
                        ->revealable()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(fn (?string $state) => filled($state)),
                    Forms\Components\TextInput::make('password_confirmation')
                        ->label('Confirme a senha')
                        ->password()
                        ->revealable()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(fn (?string $state) => filled($state)),
                    FileUpload::make('avatar')
                        ->label('Avatar')
                        ->image()
                        ->imageEditor()
                        ->acceptedFileTypes(['image/*'])
                        ->rules(['image', 'max:1024']),

                ])->columns(),
        ];
    }
}
