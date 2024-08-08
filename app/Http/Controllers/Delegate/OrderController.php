<?php

namespace App\Http\Controllers\Delegate;

use App\Events\OrderStatusUpdated;
use App\Helpers\Notifications;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Good;
use App\Models\OrderGoods;
use App\Models\Client_packages_good;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $bydate = $request->get('bydate');
        $status_id = $request->get('status_id');

        $orders = Order::where('delegate_id', $user->id);
        if ($request->exists('shipToday')) {

            $orders = Order::whereDate('updated_at', date('Y-m-d'))->where('delegate_id', $user->id)->orderBy('updated_at', 'DESC');

        } elseif ($request->exists('stores')) {

            $orders = Order::where('delegate_id', $user->id)->where('work_type', 1)->orderBy('updated_at', 'DESC');

        } elseif ($request->exists('restaurants')) {

            $orders = Order::where('delegate_id', $user->id)->where('work_type', 2)->orderBy('updated_at', 'DESC');

        } 
        elseif($request->exists('fulfillments')) {
            $orders = Order::where('delegate_id', $user->id)->where('work_type', 4)->orderBy('updated_at','DESC');
        }
        else {
            $orders = Order::where('delegate_id', $user->id)->orderBy('updated_at', 'DESC');
        }

        if (! empty($bydate) && $bydate != null) {
            if ($bydate == 'Today') {

                $today = (new \Carbon\Carbon)->today();
                //dd($today);die();
                $orders->whereDate('updated_at', $today);
            } elseif ($bydate == 'Yesterday') {

                $yesterday = (new \Carbon\Carbon)->yesterday();
                $orders->whereDate('updated_at', $yesterday);
            } elseif ($bydate == 'LastMonth') {
                $month = (new \Carbon\Carbon)->subMonth()->submonths(1);
                $orders->whereDate('updated_at', '>', $month);
            }

        }
        if ($request->status_id != null) {
            $orders->where('status_id', $request->status_id);
        }

        $orders = $orders->paginate(50);

        return view('delegate.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $user = auth()->user();

        $order = Order::where('id', $id)->where('delegate_id', $user->id)->first();
        $this->authorize('delegateShow', $order);

        if ($order) {
            if ($order->work_type == 1) {
                $statuses = Status::where('company_id', $user->company_id)->where('delegate_appear', 1)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } else {
                $statuses = Status::where('company_id', $user->company_id)->where('restaurant_appear', 1)->where('delegate_appear', 1)->orderBy('sort', 'ASC')->get();

            }

            return view('delegate.orders.show', compact('order', 'statuses'));
        } else {
            abort(404);
        }
    }

    public function edit($id)
    {
        $user = auth()->user();

        $order = Order::where('id', $id)->where('delegate_id', $user->id)->first();
        $this->authorize('delegateEdit', $order);

        if ($order) {
            if ($order->work_type == 1) {
                $statuses = Status::where('company_id', $user->company_id)->where('delegate_appear', 1)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } else {
                $statuses = Status::where('company_id', $user->company_id)->where('restaurant_appear', 1)->where('delegate_appear', 1)->orderBy('sort', 'ASC')->get();

            }

            return view('delegate.orders.edit', compact('statuses', 'order'));
        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'status_id' => 'required|numeric',
        ]);

        $order = Order::findOrFail($id);
        $status = Status::find($request->status_id);
        if ($status->otp_send_code == 1) {
            $shouldSendOtp = false; // Default to not sending OTP

            switch ($status->otp_status_send) {
                case 'all':
                    $shouldSendOtp = true; // Send OTP for all orders
                    break;

                case 'cc':
                    // Send OTP for orders paid with credit card
                    if ($order->amount_paid == 1) {
                        $shouldSendOtp = true;
                    }
                    break;

                case 'cod':
                    // Send OTP for cash on delivery orders
                    if ($order->amount_paid == 0) {
                        $shouldSendOtp = true;
                    }
                    break;
            }

            if ($shouldSendOtp) {
                $message = send_otp($order->order_id, $status->id, Auth()->user()->id);
            }
            $message = __("api_massage.A confirmation code has been sent to the customer's phone.");

            return redirect()->back()->with('message', $message);

        }
        $order->update($request->all());
        $order = Order::findOrFail($id);
        if ($order) {

                 
      

            // call helper function here
            GloablChangeStatus($order, $status->id);

            //send webhook http request to provider if exist
            if ($order->user->webhook_url) {
                event(new OrderStatusUpdated($order->id, $status->id, $order->user->webhook_url));
            }

            //  Notifications::addNotification('تعديل علي طلب الشحن', ' تم تغيير حالة طلب الشحن رقم  : ' . $order->order_id .' من '.$oldStatus.' الي '.$order->status->title, 'order', $order->user_id, 'client', $order->id);
            $notification = [
                'message' => '<h3>Change Status Successfully</h3>',
                'alert-type' => 'success',
            ];
        } else {
            $notification = [
                'message' => '<h3>Sorry.. something wrong !!</h3>',
                'alert-type' => 'error',
            ];
        }

        return back()->with($notification);
    }

   
}
