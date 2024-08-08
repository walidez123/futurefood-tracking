<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use App\Models\Order;
use App\Models\Status;
use App\Helpers\OrderHistory;
use App\Helpers\ClientTransactions;
use App\Helpers\Notifications;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\User;

class ScanOrderController
{
    public function scan(Request $request)
    {

        $work_type = $request->work_type;
        if (($request->work_type == 1 && in_array('scan_order_last_mile', app('User_permission'))) ||
        $request->work_type == 2 && in_array('scan_order_restaurant', app('User_permission')) ||
        $request->work_type == 3 && in_array('scan_order_warehouse', app('User_permission')) ||
        $request->work_type == 4 && in_array('scan_order_Fulfilmant', app('User_permission')))
        {
            if ($work_type == 1) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('client_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 2) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 3) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('storehouse_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 4) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();

            }
        // 


        return view('admin.orders.scan_new', compact('statuses', 'work_type'));
        }else{
            return redirect(url(Auth()->user()->user_type));

        }
    }

    public function checkOrderExists(Request $request)
    {
        try {
            $orderID = $request->input('orderID');

            $order = Order::where('order_id', $orderID)->firstOrFail();

            return response()->json(['exists' => true, 'status' => $order->status->title, 'username' => $order->user->name]);
        } catch (ModelNotFoundException $e) {

            return response()->json(['exists' => false], 404);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function changeStatus(Request $request)
    {
        $orderIDs = $request->input('orderIDs');
        $status = Status::where('id', $request->status_id)->first();
        foreach ($orderIDs as $orderID)
     {

            $updated = Order::where('order_id', $orderID)->first();
            $updated->update(['status_id' => $request->status_id]);

            ClientTransactions::addToClientTransactions($updated);

            OrderHistory::addToHistory($updated->id, $request->status_id);

            dispatch(new \App\Jobs\UpdateOrderStatusInProvider($updated))->delay(5);
        }

        return response()->json(['message' => $orderIDs, 'status' => $status->title, 'username' => $updated->user->name]);
    }
}
