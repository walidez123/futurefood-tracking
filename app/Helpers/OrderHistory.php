<?php

namespace App\Helpers;

use App\Models\OrderHistory as OrderHistoryModel;

class OrderHistory
{
    public static function addToHistory($order_id, $status_id, $notes = null, $latitude = null, $longitude = null)
    {
        $log = [];
        $log['order_id'] = $order_id;
        $log['status_id'] = $status_id;
        $log['notes'] = $notes;
        $log['latitude'] = $latitude;
        $log['longitude'] = $longitude;
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        OrderHistoryModel::create($log);
    }

    public static function orderHistoryLists()
    {
        return OrderHistoryModel::latest()->get();
    }
}
