<?php

namespace Scpzc\LaravelDb;

use Illuminate\Support\ServiceProvider;


class DbServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Db', function () {
            return new DbCore();
        });
    }

}
