<?php

namespace App\Http\Controllers\Client;

use App\Helpers\Notifications;
use App\Helpers\OrderHistory;
use App\Http\Controllers\Controller;
use App\Jobs\ImportOrdersFromExcel;
use App\Models\AppSetting;
use App\Models\City;
use App\Models\Client_packages_good;
use App\Models\Good;
use App\Models\Neighborhood;
use App\Models\Order;
use App\Models\OrderGoods;
use App\Models\OrderProduct;
use App\Models\Status;
use App\Models\User;
use App\Services\OrderAssignmentService;
use App\Traits\PushNotificationsTrait;
use Illuminate\Http\Request;

class ReturnOrderController extends Controller
{
    use PushNotificationsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parameterNames = $request->query->keys();

        $statusUrl = array_key_first($request->query->all());

        // Use $firstParameterValue as needed
        // dd($status);

        if (Auth()->user()->work == 1) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

        } elseif (Auth()->user()->work == 2) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

        } elseif (Auth()->user()->work == 3) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('storehouse_appear', 1)->orderBy('sort', 'ASC')->get();

        } elseif (Auth()->user()->work == 4) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();

        }

        if ($request->exists('type')) {
            $from = $request->get('from');
            $to = $request->get('to');
            $status_id = $request->get('status_id');
            if ($request->type == 'ship') {
                $orders = Order::where('is_returned',1)->whereBetween('pickup_date', [$from, $to])->where('user_id', Auth()->user()->id);
            } else {
                $orders = Order::where('is_returned',1)->whereBetween('created_at', [$from, $to])->where('user_id', Auth()->user()->id);
            }
            if ($request->status_id != null) {
                $orders->where('status_id', $status_id);
            }
            $orders = $orders->orderBy('updated_at', 'DESC')->get();

            return view('client.orders.index', compact('orders', 'statuses', 'from', 'to', 'status_id'));
        } elseif ($request->exists('bydate')) {

            $orders = Order::where('is_returned',1)->where('user_id', Auth()->user()->id)->where('status_id', $status)->orderBy('updated_at', 'DESC');
            $status_id = $request->get('status_id');

            $bydate = $request->get('bydate');

            $from = null;
            $to = null;
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
            $orders = $orders->orderBy('updated_at', 'DESC')->get();
            if (Auth()->user()->work == 1) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } else {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

            }

            return view('client.orders.index_return', compact('orders', 'statuses', 'status_id', 'from', 'to'));

        } else {

            $status = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear',1)->where('title', str_replace('_', ' ', $statusUrl))->first();
            if ($request->work_type) {
                $orders = Order::where('is_returned',1)->where('user_id', Auth()->user()->id)->orderBy('updated_at', 'DESC')->get();
            } else {
                $orders = Order::where('is_returned',1)->where('user_id', Auth()->user()->id)->where('status_id',18)->orderBy('updated_at', 'DESC')->get();

            }

            return view('client.orders.index_return', compact('orders', 'statuses'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

  
}
