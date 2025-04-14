<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('create_auction', function ($user) {
            return $user->hasRole(['admin', 'seller']);
        });

        Gate::define('edit_auction', function ($user, $auction) {
            return $user->id === $auction->user_id || $user->hasRole('admin');
        });

        Gate::define('delete_auction', function ($user, $auction) {
            return $user->id === $auction->user_id || $user->hasRole('admin');
        });
    }
}
