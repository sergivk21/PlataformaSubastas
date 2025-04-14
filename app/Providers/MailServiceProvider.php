<?php

namespace App\Providers;

use App\Services\LaravelMailer;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LaravelMailer::class, function ($app) {
            return new LaravelMailer();
        });
    }

    public function boot()
    {
        //
    }
}
