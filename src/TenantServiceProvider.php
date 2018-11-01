<?php

namespace Amorim\Tenant;

use Illuminate\Support\ServiceProvider;


class TenantServiceProvider extends ServiceProvider {
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        //Views
        $this->loadViewsFrom(__DIR__.'/views', 'tenant'); //return view(subscription::index”);
        $this->publishes([__DIR__.'/views' => resource_path('views/mjvamorim/tenant'),]);
        

        //Migrations
        //$this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes([__DIR__.'/migrations' => database_path('migrations/'),]);


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