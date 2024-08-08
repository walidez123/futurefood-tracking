<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Notifications;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Otp_code;
use App\Models\Status;
use App\Models\User;
use App\Traits\PushNotificationsTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class run_sheetController extends Controller
{
    use PushNotificationsTrait;

    public function __construct()
    {
        $this->middleware('permission:show_order', ['only' => 'index']);


    }

    public function index(Request $request)
    {
        $this->authorize('checkType', [User::class, $request->work_type]);

        $store_statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();
        $rest_statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();
        $full_statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();

        if (
            ($request->work_type == 1 && in_array('show_order', app('User_permission'))) ||
            $request->work_type == 2 && in_array('show_order_res', app('User_permission')) ||
            $request->work_type == 3 && in_array('show_order_warehouse', app('User_permission')) ||
            $request->work_type == 4 && in_array('show_order_fulfillment', app('User_permission'))
        ) {
            //
            $work_type = $request->work_type;
            $status_id = $request->status;
            $user = Auth()->user();
            $company = $user->company_setting;
            if ($work_type == 1) {
                $status_pickup = $company->status_pickup;

            } else {
                $status_pickup = $company->status_pickup_res;

            }
            $service_providers = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'service_provider')->whereHas('user_works', function ($query) use ($work_type) {
                $query->where('work', $work_type);
            })->orderBy('id', 'desc')->get();
            $cities = City::get();

            if ($request->exists('type')) {
                $from = $request->get('from');
                $to = $request->get('to');
                $user_id = $request->get('user_id');
                $status_id = $request->get('status_id');
                $delegate_id = $request->get('delegate_id');
                $contact_status = $request->get('contact_status');
                $sender_city = $request->get('sender_city');
                $receved_city = $request->get('receved_city');
                $search = $request->get('search');
                $search_order = $request->get('search_order');
                $service_provider_id = $request->get('service_provider_id');
                if ($work_type == 1) {
                    $orders = Order::where('company_id', Auth()->user()->company_id);
                } elseif ($work_type == 2) {
                    $orders = Order::where('company_id', Auth()->user()->company_id);

                }
                elseif ($work_type == 4) {
                    $orders = Order::where('company_id', Auth()->user()->company_id);

                }

                if ($from != null && $to != null) {
                    if ($request->type == 'ship') {

                        $orders = $orders->whereDate('pickup_date', '>=', $from)
                            ->whereDate('pickup_date', '<=', $to);

                    } else {
                        $orders = $orders->whereDate('created_at', '>=', $from)
                            ->whereDate('created_at', '<=', $to);
                    }
                } else {
                    $orders = Order::where('company_id', Auth()->user()->company_id)->orderBy('pickup_date', 'DESC');
                }

                if (isset($search) && $search != '') {

                    $columns = [
                        'order_id',
                        'user_id',
                        'tracking_id',
                        'sender_city',
                        'pickup_date',
                        'sender_notes',
                        'number_count',
                        'reference_number',
                        'receved_name',
                        'receved_phone',
                        'receved_email',
                        'receved_city',
                        'receved_address',
                        'receved_address_2',
                        'receved_notes',
                        'status_id',
                        'delegate_id',
                        'order_contents',
                        'amount',
                        'call_count',
                        'whatApp_count',
                        'is_finished',
                        'amount_paid',
                        'order_weight',
                        'over_weight_price',
                    ];
                    $orders = $orders->where(function ($q) use ($search, $columns) {
                        foreach ($columns as $column) {

                            $q->orWhere($column, 'LIKE', '%' . $search . '%');
                        }

                        $q->orWhereHas('user', function ($query) use ($search) {
                            $query->where('store_name', 'LIKE', '%' . $search . '%');
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
                    $orders->where('amount_paid', $contact_status);

                }
                if ($request->delegate_id != null) {
                    $orders->where('delegate_id', $request->delegate_id);
                }
                if ($request->service_provider_id != null) {
                    $orders->where('service_provider_id', $request->service_provider_id);

                }

                //bydate
                $orders = $orders->where('work_type', $work_type)->orderBy('id', 'desc')->get();
                $orderArray = $orders->toArray();

                $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
                $delegates = User::where('company_id', Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
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
                switch ($request->input('action')) {
                    case 'search':

                        return view('admin.orders.run_sheet', compact('orders', 'service_provider_id','full_statuses', 'store_statuses', 'work_type', 'clients', 'statuses', 'from', 'to', 'user_id', 'service_providers', 'status_id', 'delegates', 'contact_status', 'delegate_id', 'cities', 'sender_city', 'receved_city', 'search', 'search_order'));
                    case 'pdf':
                        $delegate = User::where('id', $request->delegate_id)->first();

                        //  $pdf = PDF::loadView('admin.orders.run_sheet_all_pdf',compact('orders'));
                        //  $name = 'orders' . '.pdf';
                        //  return $pdf->download('test');

                        return view('admin.orders.run_sheet_all_pdf', compact('orders', 'delegate'));

                }

            } else {

                $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
                $delegates = User::where('company_id', Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
                    $query->where('work', $work_type);
                })->orderBy('id', 'desc')->get();
                if ($work_type == 1) {

                    $statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

                } elseif ($work_type == 2) {

                    $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

                } elseif ($work_type == 4) {

                    $statuses = Status::where('company_id', Auth()->user()->company_id)->where('storehouse_appear', 1)->orderBy('sort', 'ASC')->get();

                } elseif ($work_type == 4) {

                    $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();

                }

                return view('admin.orders.run_sheet', compact('work_type', 'clients', 'store_statuses', 'full_statuses', 'statuses', 'delegates', 'cities', 'service_providers', 'store_statuses', 'rest_statuses'));
            }
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

}
