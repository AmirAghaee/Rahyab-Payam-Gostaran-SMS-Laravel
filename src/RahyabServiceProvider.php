<?php

namespace AmirAghaee\rahyabsms;

use Illuminate\Support\ServiceProvider;

class RahyabServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    public function register()
    {
        $this->app->singleton('Rahyabsms', function () {
            return new RahyabService();
        });
    }
}
