<?php

namespace GoodSystem\EmailVerifiable;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class EmailVerifiableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadRoutesFrom(__DIR__.'/../routes/EmailVerifiable.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'good-system.email-verifiable');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/email-verifiable.php' => config_path('email-verifiable.php')
            ], 'config');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
