<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Alumni;
use App\Models\Role;
use App\Policies\AlumniPolicy;
use App\Policies\RolePolicy;
use Filament\Facades\Filament;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies = [
        Alumni::class => AlumniPolicy::class,
        Role::class => RolePolicy::class,
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::registerNavigationGroups(['Akun', 'Alumni', 'Poliban']);
        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament.css');
        });
    }
}
