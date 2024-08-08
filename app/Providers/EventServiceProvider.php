<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\SallaEvents\OrderShipmentCreating' => [
            'App\Listeners\SallaListeners\OrderShipmentCreatingListener',
        ],
        'App\Events\SallaEvents\OrderShipmentReturnCreating' => [
            'App\Listeners\SallaListeners\OrderShipmentReturnCreatingListener',
        ],
        'App\Events\SallaEvents\ShipmentCreating' => [
            'App\Listeners\SallaListeners\ShipmentCreatingListener',
        ],
        'App\Events\SallaEvents\ShipmentCancelled' => [
            'App\Listeners\SallaListeners\ShipmentCancelledListener',
        ],
        'App\Events\SallaEvents\AppStoreAuthorize' => [
            'App\Listeners\SallaListeners\AppStoreAuthorizeListener',
        ],
        'App\Events\SallaEvents\AppUninstalled' => [
            'App\Listeners\SallaListeners\AppUninstalledListener',
        ],
        'App\Events\ZidEvents\ShipmentCreatingEvent' => [
            'App\Listeners\ZidListeners\ShipmentCreatingListener',
        ],
        'App\Events\ZidEvents\ShipmentCancelledEvent' => [
            'App\Listeners\ZidListeners\ShipmentCancelledListener',
        ],
        'App\Events\ZidEvents\AppUninstalledEvent' => [
            'App\Listeners\ZidListeners\AppUninstalledListener',
        ],
        'App\Events\ZidEvents\OrderShipmentReturnCreatingEvent' => [
            'App\Listeners\ZidListeners\OrderShipmentReturnCreatingListener',
        ],
        'App\Events\FoodicsEvents\OrderDeliveryCreated' => [
            'App\Listeners\FoodicsListeners\OrderDeliveryCreatedListener',
        ],
        'App\Events\FoodicsEvents\OrderDeliveryUpdated' => [
            'App\Listeners\FoodicsListeners\OrderDeliveryUpdatedListener',
        ],
        'App\Events\OrderStatusUpdated' => [
            'App\Listeners\NotifyOtherApps',
        ],
        'App\Events\StatusChanged' => [
            'App\Listeners\SendWebhookOnStatusChanged',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
