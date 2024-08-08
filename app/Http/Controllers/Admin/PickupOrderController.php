<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Assignment;
use App\Helpers\Notifications;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use App\Traits\PushNotificationsTrait;
use Illuminate\Http\Request;
use App\Models\CompanyServiceProvider;

class PickupOrderController extends Controller
{
    use PushNotificationsTrait;

    public function __construct()
    {
        $this->middleware('permission:show_pickup_order', ['only' => 'index']);
        $this->middleware('permission:distribution_order', ['only' => 'distribute']);
        // $this->middleware('permission:delete_order', ['only'=>'destroy']);
    }

    public function index(Request $request)
    {

        $work_type = $request->work_type;
        $user = Auth()->user();
        $company = $user->company_setting;
        if ($work_type == 1) {
            $status_id = $company->status_pickup;
        } elseif ($work_type == 2) {
            $status_id = $company->status_pickup_res;
        } elseif ($work_type == 3) {
            $status_id = $company->status_pickup_warehouse;
        } elseif ($work_type == 4) {
            $status_id = $company->status_pickup_fulfillment;
        }
        $service_providers = CompanyServiceProvider::where('company_id', Auth()->user()->company_id)->where('is_active', 1)
        ->whereHas('user_works', function ($query) use ($work_type) {
            $query->where('work', $work_type);
        })->orderBy('id', 'desc')->get();
            $cities = City::get();
        if ($request->exists('bydate')) {
            $orders = Order::where('company_id', Auth()->user()->company_id)->where('status_id', $status_id)->orderBy('pickup_date', 'ASC');
            if ($request->get('status_id') != null) {
                $status_id = $request->get('status_id');
            }
            $bydate = $request->get('bydate');
            $from = null;
            $to = null;
            if (! empty($bydate) && $bydate != null) {
                if ($bydate == 'Today') {
                    $today = (new \Carbon\Carbon)->today();
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
            $orders = $orders->where('work_type', $work_type)->orderBy('id', 'desc')->paginate(50);
            $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
            $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
                $query->where('work', $work_type);
            })->orderBy('id', 'desc')->get();
                        if ($work_type == 1) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 2) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();
            } elseif ($work_type == 3) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('warehouse_appear', 1)->orderBy('sort', 'ASC')->get();
            } elseif ($work_type == 4) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();
            }

            return view('admin.orders.pickup', compact('orders', 'service_providers', 'work_type', 'clients', 'statuses', 'delegates', 'status_id', 'from', 'to', 'cities'));
        } elseif ($request->exists('type')) {
            $from = $request->get('from');
            $to = $request->get('to');
            $user_id = $request->get('user_id');
            if ($request->get('status_id') != null) {
                $status_id = $request->get('status_id');
            }
            $delegate_id = $request->get('delegate_id');
            $contact_status = $request->get('contact_status');
            $sender_city = $request->get('sender_city');
            $receved_city = $request->get('receved_city');
            $search = $request->get('search');
            $search_order = $request->get('search_order');
            $paid = $request->get('paid');

            $service_provider_id = $request->get('service_provider_id');
            if ($from != null && $to != null) {
                if ($request->type == 'ship') {
                    $orders = Order::whereDate('pickup_date', '>=', $from)
                        ->whereDate('pickup_date', '<=', $to)->where('status_id', $status_id)->where('company_id', Auth()->user()->company_id);
                } else {
                    $orders = Order::whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to)->where('status_id', $status_id)->where('company_id', Auth()->user()->company_id);
                }
            } else {
                $orders = Order::orderBy('pickup_date', 'ASC')->where('status_id', $status_id)->where('company_id', Auth()->user()->company_id);
            }
            if (isset($search) && $search != '') {
                $columns = [
                    'order_id', 'user_id', 'tracking_id', 'sender_city',
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
            if ($paid != null) {
                    $orders->where('amount_paid', $paid);
             
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

            } elseif ($work_type == 3) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('storehouse_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 4) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();

            }

            return view('admin.orders.pickup', compact('orders', 'service_provider_id', 'service_providers', 'work_type', 'clients', 'statuses', 'from', 'to', 'user_id', 'status_id', 'delegates', 'contact_status', 'delegate_id', 'cities', 'sender_city', 'receved_city', 'search', 'search_order'));
        } else {
            $orders = Order::where('status_id', $status_id)->where('work_type', $work_type)->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->paginate(50);
            $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
            $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
                $query->where('work', $work_type);
            })->orderBy('id', 'desc')->get();
                        if ($work_type == 1) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();
            } elseif ($work_type == 2) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();
            } elseif ($work_type == 3) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('storehouse_appear', 1)->orderBy('sort', 'ASC')->get();
            } elseif ($work_type == 4) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();
            }

            return view('admin.orders.pickup', compact('orders', 'work_type', 'service_providers', 'clients', 'statuses', 'delegates', 'cities'));
        }
    }

    public function distribute(Request $request)
    {
        $request->validate([

            'delegate_id' => 'required|numeric',
            'orders' => 'required',

        ]);
        $delegate_id = $request->delegate_id;
        if ($request->type == 'data') {
            $orders = explode(',', $request['orders'][0]);
            $orders = $this->array_remove_by_value($orders, 'on');
        } else {
            $orders = $request['orders'];
        }
        if ($request->orders[0] != 0) {
            foreach ($orders as $order) {

                $orderRow = Order::where('id', $order)->first();
                $orderRow->update(['assign_pickup' => $delegate_id]);
                //  Assignment
                Assignment::addToAssignment($orderRow->id, $delegate_id, $orderRow->status_id, $type = 1);
                //
                //mob notification :)
                $user = User::findorfail($delegate_id);
                $token = $user->Device_Token;
                if ($token != null) {
                    $title = 'تمت أضافة طلب جديد ';
                    $body = 'طلب شحن جديد'.'تم اضافة طلب شحن جديد الي حسابك : '.$orderRow->order_id.'order'.$delegate_id.'delegate'.$orderRow->id;
                    // call function that will push notifications :
                    $this->sendNotification($token, $title, $body);
                }
                //  end
                Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : '.$orderRow->order_id, 'order', $delegate_id, 'delegate', $orderRow->id);
            }
            $notification = [
                'message' => '<h3>Saved Successfully</h3>',
                'alert-type' => 'success',
            ];
        } else {
            $notification = [
                'message' => '<h3>you not selected any order</h3>',
                'alert-type' => 'error',
            ];
        }

        return back()->with($notification);
    }

    public function array_remove_by_value($array, $value)
    {
        return array_values(array_diff($array, [$value]));
    }
}
