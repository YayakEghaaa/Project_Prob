<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Blade;

class OpdPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default() // ⬅️ Tambahkan ini biar panel dikenali sebagai default
            ->id('opd')
            ->path('opd')
            ->brandName('SI VERA')
            // ->favicon(asset('images/logo.jpg'))
            ->renderHook(
            'panels::global-search.after',
            fn (): string => Blade::render('
                <div class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    ' . (auth()->user()->name ?? 'Nama OPD Anda') . '
                </div>
            '))
            ->colors([
                'primary' => Color::Blue,
            ])
            // 🟢 Ini penting: biar Filament mendeteksi resource & pages dalam folder Opd
            ->discoverResources(
                in: app_path('Filament/Opd/Resources'),
                for: 'App\\Filament\\Opd\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Opd/Pages'),
                for: 'App\\Filament\\Opd\\Pages'
            )
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(
                in: app_path('Filament/Opd/Widgets'),
                for: 'App\\Filament\\Opd\\Widgets'
            )
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            // 🧩 Middleware standar Laravel + tambahan
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
                \App\Http\Middleware\OpdMiddleware::class, // custom role middleware (boleh dipertahankan)
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
