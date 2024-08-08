<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\RateOrder;
use Illuminate\Http\Request;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class RateOrderController extends Controller
{
    public function rateOrder($order_no, $mobile)
    {
        $orderCheck = Order::where('order_id', $order_no)->where('receved_phone', $mobile)->first();
        if (! empty($orderCheck)) {
            $name = $orderCheck->receved_name;

            return view('website.rate', compact('order_no', 'mobile', 'name'));
        } else {
            $notification = [
                'message' => __('website.this_order_not_found'),
                'alert-type' => 'success',
            ];

            return back()->with($notification);
        }
    }

    public function listRateOrder()
    {
        $rates = RateOrder::orderBy('created_at', 'DESC')->where('is_publish', 1)->paginate(20);

        return view('website.list_rate', compact('rates'));
    }

    public function postRateOrder(Request $request, $order_no, $mobile)
    {
        $orderCheck = Order::where('order_id', $order_no)->where('receved_phone', $mobile)->first();

        if (! empty($orderCheck)) {
            $name = $orderCheck->receved_name;
            $order_id = $orderCheck->id;
            $rate_order = new RateOrder();
            $rate_order->name = $name;
            $rate_order->order_no = $order_no;
            $rate_order->order_id = $order_id;
            $rate_order->mobile = $mobile;
            $rate_order->rate = $request->rate;
            $rate_order->review = $request->review;
            $rate_order->company_id = $orderCheck->company_id;
            $rate_order->is_publish = 1;
            $rate_order->save();
            $notification = [
                'message' => __('website.send_success'),
                'alert-type' => 'success',
            ];

            return back()->with($notification);
        } else {
            $notification = [
                'message' => __('website.this_order_not_found'),
                'alert-type' => 'danger',
            ];

            return back()->with($notification);
        }
    }

    public function printOrder(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->first();
        if (is_null($order)) {
            abort(404);
        }
        $pdf = PDF::loadView('website.show-as-pdf', ['order' => $order]);
        if (! file_exists(public_path('orders/'.$order->order_id.'.pdf'))) {
            $pdf->save(public_path('orders/'.$order->order_id.'.pdf'));
        }

        return $pdf->stream('testOrder.pdf');
    }
}
