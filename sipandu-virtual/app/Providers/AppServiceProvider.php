<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if (str_starts_with(config('app.url'), 'https://') || request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }

        Gate::define('viewAny', function ($user) {
            return $user->isAdmin();
        });
    }
}
