<?php

namespace App\Helpers;

use App\Models\Assignment as AssignmentModel;

class Assignment
{
    public static function addToAssignment($order_id, $delegate_id, $status_id, $type)
    {
        $log = [];
        $log['order_id'] = $order_id;
        $log['status_id'] = $status_id;
        $log['delegate_id'] = $delegate_id;
        $log['type_id'] = $type;
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        AssignmentModel::create($log);
    }

    public static function orderAssignmentLists()
    {
        return AssignmentModel::latest()->get();
    }
}
