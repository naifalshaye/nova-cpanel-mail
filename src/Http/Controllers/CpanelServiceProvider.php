<?php

namespace Naif\CpanelMail\Http\Controllers;

use Illuminate\Support\ServiceProvider;

class CpanelServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes('swalker2.cpanel');
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Cpanel::class, function () {
            return new Cpanel();
        });
    }
}
