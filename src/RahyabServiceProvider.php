<?php

namespace AmirAghaee\rahyabsms;

use Illuminate\Support\ServiceProvider;

class RahyabServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->singleton('Rahyabsms', function () {
            return new RahyabService();
        });
    }
}
