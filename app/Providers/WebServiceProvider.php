<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WebServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Repositories\Interfaces\AuthInterface',
            'App\Repositories\Auth');

        $this->app->bind('App\Repositories\Interfaces\ItemInterface',
            'App\Repositories\ItemRepository');

        $this->app->bind('App\Repositories\Interfaces\ConductionInterface',
            'App\Repositories\ConductionRepository');
    }

    public function boot()
    {

    }
}
