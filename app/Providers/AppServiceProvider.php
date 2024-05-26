<?php

namespace App\Providers;

use App\Listeners\AuthLogListener;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Redirect Authenticated Users
        RedirectIfAuthenticated::redirectUsing(function () {
            return route('dashboard');
        });

        // Implicitly grant "SUPER USER" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('SUPER USER') ? true : null;
        });
    }
}
