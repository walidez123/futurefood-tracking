<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Order' => 'App\Policies\OrderPolicy',
        'App\Models\User' => 'App\Policies\ClientPolicy',
        'App\Models\Pickup_order' => 'App\Policies\Order_pickupPolicy',
        'App\Models\Orders_rules' => 'App\Policies\Order_RulesPolicy',

        

        // 'App\Models\User' => 'App\Policies\DelegatePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

    }
}
