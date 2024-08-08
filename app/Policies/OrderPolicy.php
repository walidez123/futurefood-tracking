<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    //for client
    public function show(User $user, Order $order)
    {

        return $user->id === $order->user_id;
    }

    // for company
    public function adminShow(User $user, Order $order)
    {
        return $user->company_id === $order->company_id;
    }

    // for delegate
    public function delegateShow(User $user, Order $order)
    {
        return $user->id === $order->delegate_id;
    }

    // service provider
    public function serviceProviderShow(User $user, Order $order)
    {
        return $user->id === $order->service_provider_id;
    }

    public function SupervisorShow(User $user, Order $order)
    {
        $delegates = $user->SupervisorDelegate()->get();
        $Arraydelegates = $delegates->pluck('delegate_id')->toArray();
        $order = Order::whereIn('delegate_id', $Arraydelegates)->first();
        if ($order) {
            return true;
        }
    }

    //for client
    public function edit(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }

    // for company
    public function adminEdit(User $user, Order $order)
    {
        return $user->company_id === $order->company_id;
    }

    // for delegate
    public function delegateEdit(User $user, Order $order)
    {
        return $user->id === $order->delegate_id;
    }

    // service provider
    public function serviceProviderEdit(User $user, Order $order)
    {
        return $user->id === $order->service_provider_id;
    }

    public function SupervisorEdit(User $user, Order $order)
    {
        $delegates = $user->SupervisorDelegate()->get();
        $Arraydelegates = $delegates->pluck('delegate_id')->toArray();
        $order = Order::whereIn('delegate_id', $Arraydelegates)->first();
        if ($order) {
            return true;
        }
    }

    //for client
    public function delete(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }

    // for company
    public function adminDelete(User $user, Order $order)
    {
        return $user->company_id === $order->company_id;
    }

    // service provider
    public function serviceProviderDelete(User $user, Order $order)
    {
        return $user->id === $order->service_provider_id;
    }

    public function SupervisorDelete(User $user, Order $order)
    {
        $delegates = $user->SupervisorDelegate()->get();
        $Arraydelegates = $delegates->pluck('delegate_id')->toArray();
        $order = Order::whereIn('delegate_id', $Arraydelegates)->first();
        if ($order) {
            return true;
        }
    }

    public function history(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }

    // for company
    public function adminHistory(User $user, Order $order)
    {
        return $user->company_id === $order->company_id;
    }

    // service provider
    public function serviceProviderHistory(User $user, Order $order)
    {
        return $user->id === $order->service_provider_id;
    }

    public function SupervisorHistory(User $user, Order $order)
    {
        $delegates = $user->SupervisorDelegate()->get();
        $Arraydelegates = $delegates->pluck('delegate_id')->toArray();
        $order = Order::whereIn('delegate_id', $Arraydelegates)->first();
        if ($order) {
            return true;
        }
    }
}
