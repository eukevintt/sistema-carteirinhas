<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('management', function ($user) {
            return $user->role === 'management';
        });

        Gate::define('member', function ($user) {
            return $user->role === 'member';
        });

        Gate::define('dependent', function ($user) {
            return $user->role === 'dependent';
        });

        Paginator::useTailwind();
    }
}
