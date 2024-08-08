<?php

namespace App\Policies;

use App\Models\Orders_rules;
use App\Models\User;

class Order_RulesPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }



    // for company
    public function order_rules_show(User $user, Orders_rules $order)
    {
        return $user->company_id === $order->company_id;
    }


   
}
