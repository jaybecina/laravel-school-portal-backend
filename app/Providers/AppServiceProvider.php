<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // check this one here https://github.com/laravel/framework/issues/33238#issuecomment-897063577
        Event::listen(MigrationsStarted::class, function (){
            if (config('databases.allow_disabled_pk')) {
                DB::statement('SET SESSION sql_require_primary_key=0');
            }
        });

        Event::listen(MigrationsEnded::class, function (){
            if (config('databases.allow_disabled_pk')) {
                DB::statement('SET SESSION sql_require_primary_key=1');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        // Fixed | Laravel CSS Not Working |JS Not Working | Assets |Force HTTPS |Mixed Content in production
        if(config('app.env') != 'local') {
            URL::forceScheme('https');
        } else {
            URL::forceScheme('http');
        }

    }
}
