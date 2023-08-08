<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
    public function boot()
    {
        // Paginação bootstrap
        Paginator::useBootstrap();
        // Forçar https em produção
        // if (env("APP_ENV") === "production") {
        //     $this->app["request"]->server->set("HTTPS", "on");
        // }
    }
}
