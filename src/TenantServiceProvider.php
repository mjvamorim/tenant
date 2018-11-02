<?php

namespace Amorim\Tenant;

use Illuminate\Support\ServiceProvider;


class TenantServiceProvider extends ServiceProvider {
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        //Views
        //$this->loadViewsFrom(__DIR__.'/views', 'tenant'); //return view(subscription::index”);
        //$this->publishes([__DIR__.'/views' => resource_path('views/mjvamorim/tenant'),]);
        

        //Migrations
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->publishes([__DIR__.'/database/migrations' => database_path('migrations/'),]);

        //Migrations
        //$this->loadSeedsFrom(__DIR__.'/seeds');
        $this->publishes([__DIR__.'/database/seeds' => database_path('seeds/'),]);

        //Config
        //$this->loadSeedsFrom(__DIR__.'/seeds');
        $this->publishes([__DIR__.'/config/tenant.php' => config_path('tenant.php'),]);
        $this->mergeConfigFrom(
            __DIR__.'/config/tenant.php', ''
        );


        //Assets
        //$this->publishes([__DIR__.'/resources/js' => public_path('mjvamorim/tenant/js'),], 'public');
        //$this->publishes([__DIR__.'/resources/js' => public_path('mjvamorim/tenant/js'),], 'public');
        //$this->app->make('Amorim\Tenant\Controllers\TenantController');
    }

    public function register()
    {
        include __DIR__.'/routes.php';

    }
}