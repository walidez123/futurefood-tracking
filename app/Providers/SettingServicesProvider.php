<?php

namespace App\Providers;

use App\Liberary\Settings;
use Illuminate\Support\ServiceProvider;

class SettingServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['*'], Settings::class);
    }
}
