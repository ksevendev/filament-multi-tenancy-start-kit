<?php

namespace App\Providers\Filament;

use App\Filament\Clusters\Settings\Resources\FunnelsResource;
use App\Filament\Clusters\Settings\Resources\IntegrationsResource;
use App\Filament\Clusters\Settings\Resources\OriginsResource;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Tenancy\EditTeamProfile;
use App\Models\Tenant;
use Awcodes\FilamentQuickCreate\QuickCreatePlugin;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Str;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Maartenpaauw\Filament\Cashier\Stripe\BillingProvider;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->profile()
            ->tenant(
                Tenant::class,
                slugAttribute: 'slug'
            )
            ->tenantProfile(EditTeamProfile::class)
//            ->tenantBillingProvider(new BillingProvider('default'))
            // ->requiresTenantSubscription()
            ->brandLogo(fn () => view('components.logo'))
            ->databaseNotifications()
            ->databaseNotificationsPolling('60s')
            ->sidebarCollapsibleOnDesktop()
            ->navigation(true)
            ->userMenuItems([
                'profile' => MenuItem::make()->label('Perfil')
                    ->icon('heroicon-o-user'),
                'teams' => MenuItem::make()->label('Equipe')
                    ->icon('heroicon-o-users')
                    ->url(fn (): string => '/admin/'.Str::slug((Filament::getTenant()->name ?? 'teams')).'/settings/users'),
                'settings' => MenuItem::make()->label('Configurações')
                    ->icon('heroicon-o-cog')
                    ->url(fn (): string => '/admin/'.Str::slug((Filament::getTenant()->name ?? 'settings')).'/settings'),
                'improvement-requests' => MenuItem::make()->label('Solicitações')
                    ->icon('heroicon-o-document-text')
                    ->url(fn (): string => '/admin/'.Str::slug((Filament::getTenant()->name ?? 'improvement-requests')).'/improvement-requests'),
                'logout' => MenuItem::make()->label('Sair'),
            ])
            ->spa()
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->plugins([
                QuickCreatePlugin::make()
                    ->excludes([
                        FunnelsResource::class,
                        IntegrationsResource::class,
                        OriginsResource::class,
                    ]),
                FilamentSpatieLaravelBackupPlugin::make()
                    ->usingQueue('default'),
                FilamentFullCalendarPlugin::make()
                    ->selectable()
                    ->editable(),
            ])
            ->maxContentWidth(MaxWidth::Full)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([
                Dashboard::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Negócios')
                    ->icon('heroicon-o-currency-dollar'),
                NavigationGroup::make()
                    ->label('Veículos')
                    ->icon('heroicon-o-truck'),
                NavigationGroup::make()
                    ->label('Configurações')
                    ->icon('heroicon-o-cog'),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->font('Inter')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
