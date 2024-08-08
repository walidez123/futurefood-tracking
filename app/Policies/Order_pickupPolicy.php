<?php

namespace App\Policies;

use App\Models\Pickup_order;
use App\Models\User;

class Order_pickupPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    //for client
    public function show_pickup(User $user, Pickup_order $order)
    {

        return $user->id === $order->user_id;
    }

    // for company
    public function adminShow_pickup(User $user, Pickup_order $order)
    {
        return $user->company_id === $order->company_id;
    }
}
