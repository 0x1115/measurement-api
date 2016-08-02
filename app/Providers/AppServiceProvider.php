<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\DeviceRepository::class, \App\Repositories\DeviceRepositoryFractal::class);
        $this->app->bind(\App\Repositories\MeasurementRepository::class, \App\Repositories\MeasurementRepositoryFractal::class);
    }
}
