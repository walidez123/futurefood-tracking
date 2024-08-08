<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use App\Traits\PushNotificationsTrait;
use Illuminate\Http\Request;
use App\Models\CompanyServiceProvider;

class TodayOrderController extends Controller
{
    use PushNotificationsTrait;

    public function __construct()
    {
        // $this->middleware('permission:show_order', ['only'=>'index', 'show']);,
        // $this->middleware('permission:distribution_order', ['only'=>'edit', 'update']);
        // $this->middleware('permission:delete_order', ['only'=>'destroy']);
    }

    public function index(Request $request)
    {

        $work_type = $request->work_type;
        $user = Auth()->user();
        $company = $user->company_setting;
        // if ($work_type == 1) {
        //     $status_pickup = $company->status_pickup;
        // } else {
        //     $status_pickup = $company->status_pickup_res;
        // }
        $service_providers = CompanyServiceProvider::where('company_id', Auth()->user()->company_id)->where('is_active', 1)
        ->whereHas('user_works', function ($query) use ($work_type) {
            $query->where('work', $work_type);
        })->orderBy('id', 'desc')->get();
            $cities = City::get();
        if ($request->exists('bydate')) {
            $orders = Order::whereDate('created_at', date('Y-m-d'))->where('company_id', Auth()->user()->company_id)->orderBy('pickup_date', 'DESC');
            $status_id = $request->get('status_id');
            if ($request->status_id != null) {
                $orders->where('status_id', $request->status_id);
            }
            $orders = $orders->where('is_returned', 0)->where('work_type', $work_type)->orderBy('id', 'desc')->paginate(50);
            $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
            $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
                $query->where('work', $work_type);
            })->orderBy('id', 'desc')->get();
                        if ($work_type == 1) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 2) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();
            }

            return view('admin.orders.indexToday', compact('orders', 'service_providers', 'work_type', 'clients', 'statuses', 'delegates', 'status_id', 'from', 'to', 'cities'));
        } elseif ($request->exists('type')) {
            $from = $request->get('from');
            $to = $request->get('to');
            $user_id = $request->get('user_id');
            $status_id = $request->get('status_id');
            $delegate_id = $request->get('delegate_id');
            $contact_status = $request->get('contact_status');

            $sender_city = $request->get('sender_city');

            $receved_city = $request->get('receved_city');
            $search = $request->get('search');
            $service_provider_id = $request->get('service_provider_id');

            $search_order = $request->get('search_order');
            if ($work_type == 1) {
                $orders = Order::whereDate('created_at', date('Y-m-d'))->where('company_id', Auth()->user()->company_id);
            } elseif ($work_type == 2) {
                $orders = Order::whereDate('created_at', date('Y-m-d'))->where('company_id', Auth()->user()->company_id);
            }elseif ($work_type == 3) {
                $orders = Order::whereDate('created_at', date('Y-m-d'))->where('company_id', Auth()->user()->company_id);
            }elseif ($work_type == 4) {
                $orders = Order::whereDate('created_at', date('Y-m-d'))->where('company_id', Auth()->user()->company_id);
            }

            if (isset($search) && $search != '') {

                $columns = [
                    'order_id', 'user_id', 'tracking_id', 'sender_city', 'sender_phone', 'sender_address', 'sender_address_2',
                    'pickup_date', 'sender_notes', 'number_count', 'reference_number',
                    'receved_name', 'receved_phone', 'receved_email', 'receved_city', 'receved_address', 'receved_address_2',
                    'receved_notes', 'status_id', 'delegate_id', 'order_contents', 'amount', 'call_count', 'whatApp_count',
                    'is_finished', 'amount_paid', 'order_weight', 'over_weight_price',
                ];
                $orders = $orders->where(function ($q) use ($search, $columns) {
                    foreach ($columns as $column) {

                        $q->orWhere($column, 'LIKE', '%'.$search.'%');
                    }

                    $q->orWhereHas('user', function ($query) use ($search) {
                        $query->where('store_name', 'LIKE', '%'.$search.'%');
                    });
                });
            }

            if (isset($search_order) && $search_order != '') {

                $search_order_array = array_map('trim', array_filter(explode(' ', $search_order)));

                $orders = $orders->where(function ($q) use ($search_order_array) {

                    $q->whereIn('order_id', $search_order_array);
                    $q->orWhereIn('id', $search_order_array);
                    $q->orWhereIn('reference_number', $search_order_array);
                });
            }

            if ($request->sender_city != null) {
                $orders->where('sender_city', $request->sender_city);
            }

            if ($request->receved_city != null) {
                $orders->where('receved_city', $request->receved_city);
            }
            if ($request->user_id != null) {
                $orders->where('user_id', $request->user_id);
            }
            if ($request->status_id != null) {
                $orders->where('status_id', $request->status_id);
            }
            if ($request->contact_status != null) {
                //call_count
                if ($request->contact_status == 0) {
                    $orders->where('whatApp_count', 0)->where('call_count', 0);
                } else {
                    $orders->where(function ($q) {
                        $q->where(function ($q1) {
                            $q1->where('whatApp_count', 0);
                            $q1->where('call_count', '>', 0);
                        })->orWhere(function ($q2) {
                            $q2->where('whatApp_count', '>', 0);
                            $q2->where('call_count', 0);
                        });
                    });
                }
            }
            if ($request->delegate_id != null) {
                $orders->where('delegate_id', $request->delegate_id);
            }
            if ($request->service_provider_id != null) {
                $orders->where('service_provider_id', $request->service_provider_id);
            }

            //bydate
            $orders = $orders->where('work_type', $work_type)->orderBy('id', 'desc')->paginate(50);
            $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
            $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
                $query->where('work', $work_type);
            })->orderBy('id', 'desc')->get();
                        if ($work_type == 1) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 2) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();
            }elseif ($work_type == 3) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('warehouse_appear', 1)->orderBy('sort', 'ASC')->get();
            }elseif ($work_type == 4) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();
            }

            return view('admin.orders.indexToday', compact('orders', 'service_provider_id', 'service_providers', 'work_type', 'clients', 'statuses', 'from', 'to', 'user_id', 'status_id', 'delegates', 'contact_status', 'delegate_id', 'cities', 'sender_city', 'receved_city', 'search', 'search_order'));
        } else {

            $orders = Order::whereDate('created_at', date('Y-m-d'))->where('work_type', $work_type)->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->paginate(50);

            $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
            $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
                $query->where('work', $work_type);
            })->orderBy('id', 'desc')->get();
                        if ($work_type == 1) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 2) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();
            }elseif ($work_type == 3) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('warehouse_appear', 1)->orderBy('sort', 'ASC')->get();
            }elseif ($work_type == 4) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();
            }

            return view('admin.orders.indexToday', compact('orders', 'service_providers', 'work_type', 'clients', 'statuses', 'delegates', 'cities'));
        }
    }
}
