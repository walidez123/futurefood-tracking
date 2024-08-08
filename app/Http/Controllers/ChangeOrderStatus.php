<?php

namespace App\Http\Controllers;

use App\Helpers\ClientTransactions;
use App\Helpers\OrderHistory;
use App\Jobs\UpdateOrderStatusInProvider;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChangeOrderStatus extends Controller
{
    public function array_remove_by_value($array, $value)
    {
        return array_values(array_diff($array, [$value]));
    }

    public function change_status(Request $request)
    {

        $request['order_id'] = explode(',', $request['order_id'][0]);
        $request['order_id'] = $this->array_remove_by_value($request['order_id'], 'on');

        $request->validate([
            'order_id' => 'required|array',
            'order_id.*' => 'required|numeric|distinct',
            'status_id' => 'required|numeric',
        ]);

        $i = 1;
        foreach ($request['order_id'] as $orderId) {
            $order = Order::findOrFail($orderId);
            $statusId = $request->status_id;
            Log::info('OrderID: '.$orderId.'statusId: '.$statusId);
            // Update order status in your application
            $order->update([
                'status_id' => $statusId,
            ]);

            // Other actions like transactions and history updates
            ClientTransactions::addToClientTransactions($order);
            OrderHistory::addToHistory($order->id, $statusId);

            //dispatch(new UpdateOrderStatusInProvider($order))->delay($i);

            $i += 2;
        }

        $notification = [
            'message' => '<h3>Order Status changed Successfully</h3>',
            'alert-type' => 'success',
        ];

        // dd($notification);
        return redirect()->back()->with($notification);

    }
}
