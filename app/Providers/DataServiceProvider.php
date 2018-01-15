<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
{
    public function register() {
        $this->app->bind('App\Repositories\Interfaces\AuthInterface',
            'App\Repositories\Auth');

        $this->app->bind('App\Repositories\Interfaces\UserInterface',
            'App\Repositories\UserRepository');

        $this->app->bind('App\Repositories\Interfaces\UserHandleInterface',
            'App\Repositories\UserRepository');


        $this->app->bind('App\Repositories\Interfaces\ItemInterface',
            'App\Repositories\ItemRepository');

        $this->app->bind('App\Repositories\Interfaces\ItemHandleInterface',
            'App\Repositories\ItemRepository');


        $this->app->bind('App\Repositories\Interfaces\ConductionInterface',
            'App\Repositories\ConductionRepository');

        // Payments
        $this->app->bind('App\Repositories\Interfaces\PayInterface',
            'App\Repositories\PayRepository');

        $this->app->bind('App\Repositories\Interfaces\NotificationInterface',
            'App\Repositories\SystemRepository');
        $this->app->bind('App\Repositories\Interfaces\SearchInterface',
            'App\Repositories\SearchRepository');
    }

    public function boot()
    {

    }
}
