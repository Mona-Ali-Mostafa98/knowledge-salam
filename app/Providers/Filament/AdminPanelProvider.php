<?php

namespace App\Providers\Filament;

use App\Filament\Pages\EditProfile;
use App\Http\Middleware\Authenticate;
//use Filament\Http\Middleware\Authenticate;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use SolutionForest\FilamentTranslateField\FilamentTranslateFieldPlugin;
use App\Filament\Helper\CustomRegister;
use App\Filament\Helper\CustomLogin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(CustomLogin::class)
            ->registration(CustomRegister::class)
            ->profile()
            ->userMenuItems([
                'profile' => MenuItem::make()->url(fn (): string => EditProfile::getUrl())
            ])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
            ])->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
                SpatieLaravelTranslatablePlugin::make()->defaultLocales(['ar', 'en']),
                FilamentTranslateFieldPlugin::make()->defaultLocales(['ar', 'en']),
            ])->colors([
                'primary' => '#066166',
            ])
            ->databaseNotifications()
            ->darkMode(true)
            ->navigationGroups([
                NavigationGroup::make()
                    ->label(__('system.system_constants'))
                    ->icon('heroicon-o-wrench-screwdriver'),
            ])
            ->bootUsing(function () {
                Filament::serving(function () {
                    $user = Filament::auth()->user();
                    Filament::registerNavigationItems(array_filter([
                        $user?->hasRole(['reviewer'])
                            ? NavigationItem::make(__('system.Events Records need to reviewed'))
                            ->url('/admin/pending-events')
                            ->icon('heroicon-o-eye')
                            ->activeIcon('heroicon-s-eye')
                            ->group(__('system.Reviewed Records'))
                            ->sort(1)
                            : null,

                        $user?->hasRole(['reviewer'])
                            ? NavigationItem::make(__('system.Organization Records need to reviewed'))
                            ->url('/admin/organizations?tableFilters[approval_status][value]=pending')
                            ->icon('heroicon-o-eye')
                            ->activeIcon('heroicon-s-eye')
                            ->group(__('system.Reviewed Records'))
                            ->sort(2)
                            : null,

                        $user?->hasRole(['reviewer'])
                            ? NavigationItem::make(__('system.People Records need to reviewed'))
                            ->url('/admin/people?tableFilters[approval_status][value]=pending')
                            ->icon('heroicon-o-eye')
                            ->activeIcon('heroicon-s-eye')
                            ->group(__('system.Reviewed Records'))
                            ->sort(3)
                            : null,

                        $user?->hasRole(['reviewer'])
                            ? NavigationItem::make(__('system.User Records need to reviewed'))
                            ->url('/admin/pending-users')
                            ->icon('heroicon-o-eye')
                            ->activeIcon('heroicon-s-eye')
                            ->group(__('system.Reviewed Records'))
                            ->sort(4)
                            : null,

                        //******************************************************************************
                        $user?->hasRole(['approval'])
                        ? NavigationItem::make(__('system.Events Records need to approved'))
                            ->url('/admin/reviewed-events')
                            ->icon('heroicon-o-check-circle')
                            ->activeIcon('heroicon-s-check-circle')
                            ->group(__('system.Approval Records'))
                            ->sort(1)
                            : null,

                        $user?->hasRole(['approval'])
                            ? NavigationItem::make(__('system.Organization Records need to approved'))
                            ->url('/admin/organizations?tableFilters[approval_status][value]=reviewed')
                            ->icon('heroicon-o-check-circle')
                            ->activeIcon('heroicon-s-check-circle')
                            ->group(__('system.Approval Records'))
                            ->sort(2)
                            : null,

                        $user?->hasRole(['approval'])
                            ? NavigationItem::make(__('system.People Records need to approved'))
                            ->url('/admin/people?tableFilters[approval_status][value]=reviewed')
                            ->icon('heroicon-o-check-circle')
                            ->activeIcon('heroicon-s-check-circle')
                            ->group(__('system.Approval Records'))
                            ->sort(3)
                            : null,

                        $user?->hasRole(['approval'])
                            ? NavigationItem::make(__('system.User Records need to approved'))
                            ->url('/admin/reviewed-users')
                            ->icon('heroicon-o-check-circle')
                            ->activeIcon('heroicon-s-check-circle')
                            ->group(__('system.Approval Records'))
                            ->sort(4)
                            : null,

                        //******************************************************************************
                        $user?->hasAnyRole(['publisher', 'super_admin'])
                            ? NavigationItem::make(__('system.Events Records need to published'))
                            ->url('/admin/approved-events')
                            ->icon('heroicon-o-arrow-up-tray')
                            ->activeIcon('heroicon-s-arrow-up-tray')
                            ->group(__('system.Published Records'))
                            ->sort(1)
                            : null,

                        $user?->hasAnyRole(['publisher', 'super_admin'])
                            ? NavigationItem::make(__('system.Organization Records need to published'))
                            ->url('/admin/organizations?tableFilters[approval_status][value]=approved&tableFilters[is_published][value]=0')
                            ->icon('heroicon-o-arrow-up-tray')
                            ->activeIcon('heroicon-s-arrow-up-tray')
                            ->group(__('system.Published Records'))
                            ->sort(2)
                            : null,

                        $user?->hasAnyRole(['publisher', 'super_admin'])
                            ? NavigationItem::make(__('system.People Records need to published'))
                            ->url('/admin/people?tableFilters[approval_status][value]=approved&tableFilters[is_published][value]=0')
                            ->icon('heroicon-o-arrow-up-tray')
                            ->activeIcon('heroicon-s-arrow-up-tray')
                            ->group(__('system.Published Records'))
                            ->sort(3)
                            : null,

                        $user?->hasAnyRole(['publisher', 'super_admin'])
                            ? NavigationItem::make(__('system.User Records need to published'))
                            ->url('/admin/approved-users')
                            ->icon('heroicon-o-arrow-up-tray')
                            ->activeIcon('heroicon-s-arrow-up-tray')
                            ->group(__('system.Published Records'))
                            ->sort(4)
                            : null,
                    ]));
                });
            })
            ->brandLogo(asset('images/salam.png'))
            ->sidebarCollapsibleOnDesktop()
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
