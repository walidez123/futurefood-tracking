<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderStatusUpdated;
use App\Helpers\ClientTransactions;
use App\Helpers\CompanyTransactions;
use App\Helpers\Notifications;
use App\Helpers\OrderHistory;
use App\Http\Controllers\Controller;
use App\Jobs\ImportOrdersFromExcelAdmin;
use App\Models\AppSetting;
use App\Models\City;
use App\Models\Client_packages_good;
use App\Models\Good;
use App\Models\Neighborhood;
use App\Models\Order;
use App\Models\OrderGoods;
use App\Models\OrderProduct;
use App\Models\Otp_code;
use App\Models\Status;
use App\Models\User;
use App\Models\Address;
use App\Models\CompanyProviderStatuses;
use GuzzleHttp\Exception\RequestException;
use App\Services\Adaptors\Aymakan\Aymakan;
use App\Services\Adaptors\Farm\Farm;
use App\Services\Adaptors\Farm\FarmTest;
use App\Services\Adaptors\LaBaih\LaBaih;
use App\Services\OrderAssignmentService;
use App\Traits\PushNotificationsTrait;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use App\Models\Packages_history;
use ZipStream\ZipStream;
use ZipStream\Option\Archive;
use ZipStream\Option\File;
use App\Services\Adaptors\SmbExpress\SmbExpress;
use App\Models\Smb_city;
use App\Models\CompanyServiceProvider;


use niklasravnsborg\LaravelPdf\Facades\Pdf;


// use PDF;

class OrderController extends Controller
{
    use PushNotificationsTrait;

    public function __construct()
    {
        $this->middleware('permission:change_status', ['only' => 'change_status']);
        $this->middleware('permission:distribution_order', ['only' => 'distribute']);
        $this->middleware('permission:assign_service_provider', ['only' => 'assign_to_service_provider']);
        $this->middleware('permission:show_history_order', ['only' => 'history']);
        $this->middleware('permission:delete_otp_order', ['only' => 'otp_delete']);

    }

    public function index(Request $request)
    {
        $this->authorize('checkType', [User::class, $request->work_type]);

        $perPage = 50; 
        $page = request()->has('page') ? request()->query('page') : 1; 

        if (($request->work_type == 1 && in_array('show_order', app('User_permission'))) ||
        $request->work_type == 2 && in_array('show_order_res', app('User_permission')) ||
        $request->work_type == 3 && in_array('show_order_warehouse', app('User_permission')) ||
        $request->work_type == 4 && in_array('show_order_fulfillment', app('User_permission')) ||
        $request->exists('notDelegated2') && in_array('show_order_res', app('User_permission')) ||
        $request->exists('notDelegated1') && in_array('show_order', app('User_permission'))) {
            $work_type = $request->work_type;

            if ($work_type == 1) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 2) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 3) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('storehouse_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 4) {
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();

            }
            //
            $status_id = $request->status;
            $user = Auth()->user();
            $service_providers = CompanyServiceProvider::where('company_id', Auth()->user()->company_id)->where('is_active', 1)
            ->whereHas('user_works', function ($query) use ($work_type) {
                $query->where('work', $work_type);
            })->orderBy('id', 'desc')->get();


            $cities = City::get();

            if ($request->exists('notDelegated1') || $request->exists('notDelegated2') || $request->type == 'notDelegated' || $request->type == 'notDelegated1' || $request->type == 'notDelegated2') {

                $sender_city = $request->get('sender_city');

                $receved_city = $request->get('receved_city');
                $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
                    $query->where('work', $work_type);
                })->orderBy('id', 'desc')->get();
                if ($request->exists('notDelegated1') || $request->type == 'notDelegated1') {
                    $work_type = 1;
                    $orders = Order::NotDelegated()->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc');
                    $delegatedorders = Order::whereNotNull('delegate_id')->where('company_id', Auth()->user()->company_id)->where('work_type', 2)->orderBy('id', 'desc');

                }
                if ($request->exists('notDelegated2') || $request->type == 'notDelegated2') {
                    $work_type = 2;

                    $orders = Order::NotDelegatedRes()->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc');
                    $delegatedorders = Order::whereNotNull('delegate_id')->where('company_id', Auth()->user()->company_id)->where('work_type', 2)->orderBy('id', 'desc');

                }

                if ($request->sender_city != null) {
                    $orders = $orders->where('sender_city', $request->sender_city);
                    $delegatedorders = $delegatedorders->where('sender_city', $request->sender_city);
                }

                if ($request->receved_city != null) {
                    $orders = $orders->where('receved_city', $request->receved_city);
                    $delegatedorders = $delegatedorders->where('receved_city', $request->receved_city);
                }

                $orders = $orders->get();

                $delegatedorders = $delegatedorders->where('is_returned', 0)->get();

                return view('admin.orders.not-distributed', compact('work_type', 'orders', 'delegates', 'delegatedorders', 'cities', 'sender_city', 'receved_city', 'service_providers'));

            } elseif ($request->exists('bydate')) {

                $orders = Order::where('company_id', Auth()->user()->company_id)->orderBy('pickup_date', 'DESC');
                $status_id = $request->get('status_id');

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
                
                $orders = $orders->where('is_returned', 0)
                    ->where('work_type', $work_type)
                    ->orderBy('id', 'desc')
                    ->paginate($perPage, ['*'], 'page', $page);

                $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
                $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
                    $query->where('work', $work_type);
                })->orderBy('id', 'desc')->get();                

                return view('admin.orders.index', compact('orders', 'work_type', 'clients', 'statuses', 'delegates', 'status_id', 'from', 'to', 'cities', 'service_providers'));

            } elseif ($request->exists('type')) {
                $from = $request->get('from');
                $to = $request->get('to');
                $user_id = $request->get('user_id');
                $status_id = $request->get('status_id');
                $delegate_id = $request->get('delegate_id');
                $contact_status = $request->get('contact_status');
                $paid = $request->get('paid');

                $sender_city = $request->get('sender_city');

                $receved_city = $request->get('receved_city');
                $search = $request->get('search');

                $search_order = $request->get('search_order');
                $service_provider_id = $request->get('service_provider_id');
                $orders = Order::where('company_id', Auth()->user()->company_id);


                if ($from != null && $to != null) {
                    if ($request->type == 'ship') {

                        $orders = $orders->whereDate('pickup_date', '>=', $from)
                            ->whereDate('pickup_date', '<=', $to);

                    } else {
                        $orders = $orders->whereDate('created_at', '>=', $from)
                            ->whereDate('created_at', '<=', $to);
                    }
                } else {
                    $orders = $orders->orderBy('pickup_date', 'DESC');
                }

                if (isset($search) && $search != '') {
                    $this->quickSearch($orders, $search)->get();
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
                if ($paid != null) {
                    if ($paid == 0) {
                        $orders->where('amount_paid', 0);
                    } else {
                        $orders->where('amount_paid', 1);
                    }
                }
                if ($request->delegate_id != null) {
                    $orders->where('delegate_id', $request->delegate_id);
                }
                if ($request->service_provider_id != null) {
                    $orders->where('service_provider_id', $request->service_provider_id);

                }

                //bydate
                $orders = $orders->where('is_returned', 0)->where('work_type', $work_type)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
                $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
                $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
                    $query->where('work', $work_type);
                })->orderBy('id', 'desc')->get();               
                

                return view('admin.orders.index', compact('orders', 'service_provider_id', 'work_type', 'clients', 'statuses', 'from', 'to', 'user_id', 'service_providers', 'status_id', 'delegates', 'paid','contact_status', 'delegate_id', 'cities', 'sender_city', 'receved_city', 'search', 'search_order'));
            } else {

                $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
                $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
                    $query->where('work', $work_type);
                })->orderBy('id', 'desc')->get();
                                if ($work_type == 1) {
                    if ($request->status != null) {
                        $orders = Order::where('is_returned', 0)->where('work_type', 1)->where('status_id', $request->status)->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);


                    } else {
                        $orders = Order::where('is_returned', 0)->where('work_type', 1)->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);


                    }


                } elseif ($work_type == 2) {
                    if ($request->status != null) {
                        $orders = Order::where('is_returned', 0)->where('work_type', 2)->where('status_id', $request->status)->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

                    } else {
                        $orders = Order::where('is_returned', 0)->where('work_type', 2)->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
                    }

                    $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

                } elseif ($work_type == 3) {
                    if ($request->status != null) {
                        $orders = Order::where('is_returned', 0)->where('work_type', 3)->where('status_id', $request->status)->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

                    } else {
                        $orders = Order::where('is_returned', 0)->where('work_type', 3)->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);


                    }

                    $statuses = Status::where('company_id', Auth()->user()->company_id)->where('storehouse_appear', 1)->orderBy('sort', 'ASC')->get();

                } elseif ($work_type == 4) {
                    if ($request->status != null) {
                        $orders = Order::where('is_returned', 0)->where('work_type', 4)->where('status_id', $request->status)->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

                    } else {
                        $orders = Order::where('is_returned', 0)->where('work_type', 4)->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);


                    }

                    $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();

                }
                $status_id=$request->status;

                return view('admin.orders.index', compact('orders', 'work_type', 'clients', 'statuses', 'delegates', 'cities', 'service_providers','status_id'));
            }
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    

  

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('checkType', [User::class, $order->work_type]);

        if (($order->work_type == 1 && in_array('show_order', app('User_permission'))) ||
           $order->work_type == 2 && in_array('show_order_res', app('User_permission')) ||
           $order->work_type == 3 && in_array('show_order_warehouse', app('User_permission')) ||
           $order->work_type == 4 && in_array('show_order_fulfillment', app('User_permission'))
        || $order->work_type == 1 && in_array('show_pickup_order', app('User_permission'))
        || ($order->work_type == 1 && in_array('show_return_order', app('User_permission')))
        ||
        $order->work_type == 2 && in_array('show_return_order_res', app('User_permission'))
        ) {

            $this->authorize('adminShow', $order);
            $otps = Otp_code::where('order_id', $order->order_id)->orderBy('id', 'desc')->get();
            if ($order) {

                if ($order->work_type == 1) {
                    $statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();
    
                } elseif ($order->work_type == 2) {
                    $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();
    
                } elseif ($order->work_type == 3) {
                    $statuses = Status::where('company_id', Auth()->user()->company_id)->where('storehouse_appear', 1)->orderBy('sort', 'ASC')->get();
    
                } elseif ($order->work_type == 4) {
                    $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();
    
                }

                if($order->is_returned==1)
                {
                    return view('admin.orders.show_return', compact('order', 'otps', 'statuses'));

    
                }else{
                    return view('admin.orders.show', compact('order', 'otps', 'statuses'));
    
                }
               

            } else {
                abort(404);
            }
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    public function otp_delete($id)
    {
        Otp_code::where('id', $id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    public function create(request $request)
    {

        $this->authorize('checkType', [User::class, $request->work_type]);

        if (($request->work_type == 1 && in_array('add_order', app('User_permission'))) || $request->work_type == 2 && in_array('add_order_res', app('User_permission'))
        || $request->work_type == 3 && in_array('add_order_warehouse', app('User_permission'))
        || $request->work_type == 4 && in_array('add_order_fulfillment', app('User_permission'))
        ) {
            $work_type = $request->work_type;

            $goods = Good::where('company_id', Auth()->user()->company_id)->get();
            $cities = City::get();

            $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $request->work_type)->get();
            if ($request->work_type == 2) {
                return view('admin.orders.addRest', compact('clients', 'cities'));

            } else {
                return view('admin.orders.add', compact('clients', 'cities', 'goods', 'work_type'));

            }

        } else {
            return redirect(url(Auth()->user()->user_type));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('adminEdit', $order);


        if (($order->work_type == 1 && in_array('edit_order', app('User_permission'))) ||
        $order->work_type == 2 && in_array('edit_order_res', app('User_permission'))
     || $order->work_type == 1 && in_array('edit_pickup_order', app('User_permission'))
     || ($order->work_type == 1 && in_array('edit_return_order', app('User_permission'))) ||
        $order->work_type == 2 && in_array('edit_return_order_res', app('User_permission')) ||
        $order->work_type == 4 && in_array('edit_order_fulfillment', app('User_permission'))
        ) {

            // $this->authorize('adminEdit', $order);

            if ($order) {
                $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($order) {
                    $query->where('work', $order->work_type);
                })->orderBy('id', 'desc')->get();     
                $cities = City::get();

                $neighborhood = Neighborhood::where('id', $order->neighborhood_id)->first();
                $products = OrderProduct::where('order_id', $id)->get();
                $goods = Good::where('client_id', $order->user_id)->get();

                $user = User::where('id', $order->user_id)->first();
                $addresses = [];
                if (! empty($user)) {
                    $addresses = $user->addresses()->get();
                }
                if ($order->work_type == 1 || $order->work_type == 4) {
                    return view('admin.orders.edit', compact('delegates', 'order', 'addresses', 'user', 'cities', 'neighborhood', 'goods'));
                } else {
                    return view('admin.orders.editRest', compact('delegates', 'order', 'addresses', 'user', 'cities', 'neighborhood', 'products'));

                }

            } else {
                abort(404);
            }
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    public function update(Request $request, $id)
    {

        /* $request->validate([

        'delegate_id'  => 'required|numeric'
        ]);

        $request->validate([
        'sender_city'                       => 'required',
        'sender_phone'                      => 'required|numeric',
        'sender_address'                    => 'required|min:10',
        'sender_address_2'                  => 'required|min:10',
        'pickup_date'                       => 'required',
        'receved_name'                      => 'required|min:5',
        'receved_phone'                     => 'required|numeric',
        'receved_city'                      => 'required',
        'receved_address'                   => 'required|min:10',
        'receved_address_2'                 => 'required|min:10',
        ]);

         */

        $order = Order::findOrFail($id);
        $this->authorize('checkType', [User::class, $order->work_type]);

        if (($order->work_type == 1 && in_array('edit_order', app('User_permission'))) ||
        $order->work_type == 2 && in_array('edit_order_res', app('User_permission'))
     || $order->work_type == 1 && in_array('edit_pickup_order', app('User_permission'))
     || ($order->work_type == 1 && in_array('edit_return_order', app('User_permission')))
     ||
     $order->work_type == 2 && in_array('edit_return_order_res', app('User_permission')) ||
     $order->work_type == 4 && in_array('edit_order_fulfillment', app('User_permission'))
        ) {

            $order->update($request->all());
            if ($request->product_name) {
                OrderProduct::where('order_id', $id)->delete();

                foreach ($request->product_name as $i => $product_name) {
                    $order_products = new OrderProduct();
                    $order_products->product_name = $product_name;
                    $order_products->size = $request->size[$i];
                    $order_products->number = $request->number[$i];
                    $order_products->order_id = $order->id;
                    $order_products->save();
                }
            }
            if ($request->good_id) {
                OrderGoods::where('order_id', $id)->delete();

                foreach ($request->good_id as $i => $good_id) {
                    $order_products = new OrderGoods();
                    $order_products->good_id = $good_id;
                    $order_products->number = $request->number[$i];
                    $order_products->order_id = $order->id;
                    $order_products->save();
                }
            }
            $notification = [
                'message' => '<h3>Saved Successfully</h3>',
                'alert-type' => 'success',
            ];

            /* Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : '.$order->order_id, 'order', $request->delegate_id, 'delegate', $order->id);
            $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
            );

             */
            return redirect()->route('client-orders.index', ['work_type' => $order->work_type])->with($notification);
        } else {
            return redirect(url(Auth()->user()->user_type));
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
                $orderRow->update(['delegate_id' => $delegate_id]);
                //mob notification :)
                $user = User::findorfail($delegate_id);
                $token = $user->Device_Token;
                // if ($token != null) {
                //     $title = 'تمت أضافة طلب شحن جديد ';
                //     $body = 'تم اضافة طلب شحن جديد الي حسابك : '.$orderRow->order_id;
                //     // call function that will push notifications :
                //     $this->sendNotification($token, $title, $body);
                // }
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

    //
    public function store(Request $request)
    {

        $request->validate([
            // 'sender_city' => 'required',
            'receved_name' => 'required|min:2',
            'receved_phone' => 'required|max:10|starts_with:05',
            'receved_city' => 'nullable',
            'reference_number' => 'nullable',
            'receved_email' => 'nullable|email',
            'amount' => 'required|numeric',
            'good_id.*' => [
                Rule::exists('goods', 'id')->where(function ($query) {
                    return $query->where('company_id', Auth()->user()->company_id);
                }),
            ],
        ]);
        if ($request->good_id) {
            foreach ($request->good_id as $i => $good_id) {
                $good = Good::find($good_id);
                $sum = $good->Client_packages_goods->sum('number');
                if ($sum < $request->number[$i]) {
                    return redirect()->back()->with('error', __('goods.This number of product is not available in stock'));
                }
            }
        }

        $user = User::where('id', $request->user_id)->first();
        $address = Address::where('id', $request->store_address_id )->first();
        $this->authorize('checkType', [User::class, $user->work]);

        if ((
            $user->work == 1 && in_array('add_order', app('User_permission'))) ||
            $user->work == 2 && in_array('add_order_res', app('User_permission')) ||
            $user->work == 3 && in_array('add_order_warehouse', app('User_permission')) ||
            $user->work == 4 && in_array('add_order_fulfillment', app('User_permission')) ||
            $user->work == 1 && in_array('add_pickup_order', app('User_permission'))
        ) {

            $appSetting = AppSetting::findOrFail(1);
            $orderData = $request->all();
            $order = new Order();
            $lastOrderID = $order->withTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
            $newOrderID = $lastOrderID + 1;
            $lengthOfNewOrderId = strlen((string) $newOrderID);
            if ($lengthOfNewOrderId < 7) {
                for ($i = 0; $i < $lengthOfNewOrderId; $i++) {
                    $newOrderID = '0'.$newOrderID;
                }
            }
            $orderId = $appSetting->order_number_characters.$newOrderID;

            $orderData['order_id'] = $orderId;
            $orderData['work_type'] = $user->work;
            $orderData['company_id'] = $user->company_id;
            $trackId = $user->tracking_number_characters.'-'.uniqid();
            $orderData['tracking_id'] = $trackId;
            $orderData['status_id'] = $user->default_status_id;
            $orderData['receved_phone'] = '966'.$request->receved_phone;
            // $orderData['sender_city'] = $address->city_id;
            $orderData['sender_city'] = $address ? $address->city_id : "";

            if ($request->map_or_link == 'link'){
                $orderData['longitude'] = null;
                $orderData['latitude'] = null;
            }
            //
            if ($request->good_id) {
                $request->validate([
                    'good_id' => 'required',
                    'number' => 'required',
                ]);
            }

            //

            $savedOrder = $user->orders()->create($orderData);
            $assignmentService = new OrderAssignmentService();
            $assignmentService->assignToDelegate($savedOrder->id);
            $assignmentService->assignToService_Provider($savedOrder->id);
            $savedOrder=Order::find($savedOrder->id);

                //mob notification :)
                // if ($savedOrder->delegate_id != null) {
                //     $user = User::findorfail($savedOrder->delegate_id);
                //     $token = $user->Device_Token;
                //     if ($token != null) {
                //         $title = 'تمت أضافة طلب جديد ';
                //         $body = 'طلب شحن جديد'.'تم اضافة طلب شحن جديد الي حسابك : '.$savedOrder->order_id.'order'.$user->id.'delegate'.$savedOrder->id;
                //         // call function that will push notifications :
                //         $this->sendNotification($token, $title, $body);
                //     }
                // }
        

            if ($request->product_name) {
                $request->validate([
                    'product_name.*' => 'nullable', 
                    'size.*' => 'nullable',
                    'number.*' => 'nullable',
                ]);
                foreach ($request->product_name as $i => $product_name) {
                   
                    if ($product_name !== null) {
                        $order_product = new OrderProduct();
                        $order_product->product_name = $product_name;
                        $order_product->size = $request->size[$i];
                        $order_product->number = $request->number[$i];
                        $order_product->order_id = $savedOrder->id;
                        $order_product->save();
                    }
                }
            }
            if ($request->good_id) {

                $request->validate([
                    'good_id' => 'required',
                    'number' => 'required',
                ]);

                

                foreach ($request->good_id as $i => $good_id) {
                   $good = Good::find($good_id);
                    $order_goods = new OrderGoods();
                    $order_goods->good_id = $good_id;
                    $order_goods->number = $request->number[$i];
                    $order_goods->order_id = $savedOrder->id;
                    $order_goods->save();
                 
                }
            }

            
        if($savedOrder->work_type==4 && $savedOrder->status_id==$savedOrder->user->userStatus->shortage_order_quantity_f_stock)
        {
            $this->shortage_quenteny_from_stock($savedOrder->id);
        }
        if($savedOrder->work_type==4 && $savedOrder->status_id==$savedOrder->user->userStatus->restocking_order_quantity_to_stock)
        {
            $this->restocking_order_quantity_to_stock($savedOrder->id);
        }


            OrderHistory::addToHistory($savedOrder->id, $savedOrder->status_id);

            if ($savedOrder) {
                Notifications::addNotification('تم أضافة طلب جديد ', 'تم اضافة طلب شحن جديد الي حسابك : '.$savedOrder->order_id, 'order', $savedOrder->user_id, 'client', $order->id);

                return redirect()->route('client-orders.index', ['work_type' => $savedOrder->work_type])->with('success', __('admin_message.created new order successfully'));
            } else {
                return redirect()->route('client-orders.index', ['work_type' => $savedOrder->work_type])->with('error', __('admin_message.Somthing went wrong!'));
            }
        } else {
            return redirect(url(Auth()->user()->user_type));
        }

    }

    public function history($id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('checkType', [User::class, $order->work_type]);

        $this->authorize('adminHistory', $order);

        if ($order) {

            $histories = $order->history()->get();

            return view('admin.orders.history', compact('histories', 'order'));
        } else {
            abort(404);
        }

    }

    public function destroy($id)
    {

        $order = Order::findOrFail($id);
        $this->authorize('checkType', [User::class, $order->work_type]);

        $this->authorize('adminDelete', $order);

        if (($order->work_type == 1 && in_array('delete_order', app('User_permission'))) || $order->work_type == 2 && in_array('delete_order_res', app('User_permission'))
            || $order->work_type == 4 && in_array('delete_order_fulfillment', app('User_permission'))
           
        ) {

            $this->authorize('adminDelete', $order);
            Order::findOrFail($id)->delete();

            $notification = [
                'message' => '<h3>Delete Successfully</h3>',
                'alert-type' => 'success',
            ];

            return back()->with($notification);
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    public function createReturnOrder(Order $order)
    {
        $this->authorize('checkType', [User::class, $order->work_type]);

        if (($order->work_type == 1 && in_array('add_return_order', app('User_permission'))) || $order->work_type == 2 && in_array('add_return_order', app('User_permission'))) {

            $appSettings = AppSetting::first();
            $lastOrderID = Order::withoutTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
            $newOrderID = $lastOrderID + 1;
            $lengthOfNewOrderId = strlen((string) $newOrderID);
            if ($lengthOfNewOrderId < 7) {
                for ($i = 0; $i < 7; $i++) {
                    $newOrderID = '0'.$newOrderID;
                }
            }

            $orderId = $appSettings->order_number_characters.$newOrderID;

            $status = $order->user->default_status_id;
            if ($order->work_type == 1) {
                $status = Auth()->user()->company_setting->status_return_shop;
            } else {
                $status = Auth()->user()->company_setting->status_return_res;

            }

            $returnOrder = Order::create([
                'order_id' => $orderId,
                'user_id' => $order->user_id,
                'tracking_id' => $order->user->tracking_number_characters.'-'.uniqid(),
                'number_count' => $order->number_count,
                'sender_name' => $order->receved_name,
                'sender_email' => $order->receved_email,
                'sender_city' => $order->receved_city,
                'sender_phone' => $order->receved_phone,
                'sender_address' => $order->receved_address,
                'sender_address_2' => $order->receved_address_2,
                'pickup_date' => now()->toDateString(),
                'receved_name' => $order->sender_name,
                'receved_phone' => $order->sender_phone,
                'receved_email' => $order->sender_email,
                'receved_city' => $order->sender_city,
                'receved_address' => $order->sender_address,
                'receved_address_2' => $order->sender_address_2,
                'order_contents' => $order->order_contents,
                'amount' => $order->amount,
                'order_weight' => $order->order_weight,
                'over_weight_price' => $order->over_weight_price,
                'call_count' => $order->call_count,
                'whatApp_count' => $order->whatApp_count,
                'provider' => $order->provider,
                'provider_order_id' => $order->provider_order_id,
                'is_returned' => 1,
                'return_order_id' => $order->id,
                'company_id' => $order->company_id,
                'work_type' => $order->work_type,
                'status_id' => $status,

            ]);
            $order = $returnOrder;
            OrderHistory::addToHistory($returnOrder->id, $returnOrder->user->default_status_id);
            Notifications::addNotification('طلب شحن مرتجع', 'تم اضافة طلب شحن مرتجع جديد برقم  : '.$returnOrder->order_id, 'order', null, 'admin');
            $otps = Otp_code::where('order_id', $order->order_id)->orderBy('id', 'desc')->get();

            // {{ route('client-orders.show', $order->id) }}
            return redirect()->route('client-orders.show', $order->id);

            // return view('admin.orders.show', compact('order', 'otps'));
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    //

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
        $orders = count($request['order_id']);

        for ($i = 0; $i < $orders; $i++) {

            $id = $request->order_id[$i];
            $status_id = $request->status_id;
            $order = Order::findOrFail($id);
            $order->update([
                'status_id' => $status_id,
            ]);

         

            if($order->work_type==4 && $status_id==$order->user->userStatus->shortage_order_quantity_f_stock)
            {
                $this->shortage_quenteny_from_stock($order->id);
            }
            if($order->work_type==4 && $order->status_id==$order->user->userStatus->restocking_order_quantity_to_stock)
            {
                $this->restocking_order_quantity_to_stock($order->id);
            }
            if($order->user->id == 611 && $order->status->id == 220)  {
                if($order->payment_method != 3){$order->update(['amount_paid' => 1]);}
                FarmApi($order->reference_number);
             }elseif($order->user->id == 572 && $order->status->id == 220 ){
                if($order->payment_method != 3){$order->update(['amount_paid' => 1]);}

                FarmApi($order->reference_number);
             }
            ClientTransactions::addToClientTransactions($order);

            OrderHistory::addToHistory($order->id, $status_id);

            

            // if ($order->user->webhook_url) {
            //     event(new OrderStatusUpdated($order->id, $status_id, $order->user->webhook_url));
            // }

            dispatch(new \App\Jobs\UpdateOrderStatusInProvider($order))->delay($i + 5);
            //
            if ($order->service_provider_id != null) {
                $company_provider_status = CompanyProviderStatuses::where('company_id', $order->company_id)->where('provider_name', 'smb')->first();

                if ($order->service_provider->provider == 'labaih') {
                    $this->Labaih_Apis($order, $order->service_provider);
                }
                elseif ($order->service_provider->id == 908) {
                    if($status_id == $company_provider_status->closed_id )  {
                        $this->SmbExpressCancelOrder($order, $order->service_provider);
                    } 
                    
                    // if($status_id == $company_provider_status->returned_id){
                    //     $this->SmbExpressReturn($order, $order->service_provider);
                    // } 
                }

            }
        }

        return back()->with('success', trans('admin_message.order_status_change_success'));

    }

    //assign_to_service_provider
    public function assign_to_service_provider(request $request)
    {


            $request->validate([
                'order_id' => 'required|numeric',
                'service_provider_id' => 'required|numeric',
            ]);
        
        $service_provider = User::find($request->service_provider_id);


            $id = $request->order_id;
            $service_provider_id = $request->service_provider_id;
            $order = Order::findOrFail($id);


            if ($service_provider->provider == 'labaih') {
                if($order->sender_city  != null){
                    $data = LaBaih::send_order($order);
                    $data = json_decode($data->getBody(), true);
                    if ($data['status'] == 200) {

                        $order->update([
                            'consignmentNo' => $data['consignmentNo'],
                            'service_provider_id' => $service_provider_id,

                        ]);
                        Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : '.$order->order_id, 'order', $service_provider_id, 'service provider', $order->id);
                    }
                }
                

            }elseif ($service_provider->id == 568) {
                
                $this->checkAymakanCities($order, $service_provider_id);

            }elseif ($service_provider->id == 908) {
                
                $this->SmbExpressApis($order, $service_provider_id);

            } else {
                $order->update([
                    'service_provider_id' => $service_provider_id,

                ]);
                Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : '.$order->order_id, 'order', $service_provider_id, 'service provider', $order->id);

            }
        

        return back();

    }

    public function Labaih_Apis($order, $service_provider_id)
    {

        $company_setting = Auth()->user()->company_setting;
        // send order
        if ($company_setting->send_order_service_provider == $order->status_id && $order->work_type == 1) {

            $data = LaBaih::send_order($order);
            $data = json_decode($data->getBody(), true);
            if ($data['status'] == 200) {

                $order->update([
                    'consignmentNo' => $data['consignmentNo'],
                    'service_provider_id' => $service_provider_id,

                ]);
                Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : '.$order->order_id, 'order', $service_provider_id, 'service provider', $order->id);
            }
        }
        //  return order
        if ($company_setting->Return_order_service_provider == $order->status_id && $order->work_type == 1 && $order->consignmentNo != null) {
            $consignmentNo = $order->consignmentNo;

            $data = LaBaih::Return_order($consignmentNo);

        }
        //Cancel order
        if ($company_setting->cancel_order_service_provider == $order->status_id && $order->work_type == 1 && $order->consignmentNo != null) {

            $consignmentNo = $order->consignmentNo;
            $data = LaBaih::Cancel_order($consignmentNo);
        }
    }

    public function aymakanApis($order, $service_provider_id)
    {
        try {
            $response = Aymakan::createShipment($order);
            
            if ($response->getStatusCode() === 200) { // Check if the HTTP status code is 200 (OK)
                $responseData = json_decode($response->getBody()->getContents(), true);
                // Handle the response data
                
                $order->update([
                    'service_provider_id' => $service_provider_id,
                    'consignmentNo' => $responseData['data']['shipping']['tracking_number'],
                ]);
        
                Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : '.$order->order_id, 'order', $service_provider_id, 'service provider', $order->id);
            } else {
                return redirect()->back()->with('error', 'Aymakan API request failed: The given data was invalid.');
            }
        } catch (RequestException $e) {
            // Handle Guzzle HTTP request exceptions
            \Log::error('Aymakan API request failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Aymakan API request failed');
        } catch (Exception $e) {
            // Handle other exceptions
            \Log::error('Aymakan API request failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Aymakan API request failed');
        }

    }

    public function FarmApi($reference_number)
    {

        try {
            $response = Farm::changeOrderStatusToDeliverd($reference_number);
            $data = json_decode($response, true);

            // Check if the operation was successful
            if(isset($data['status']) && isset($data['status']['success']) && $data['status']['success'] === false) {

                $errorMessage = $data['status']['otherTxt'];
                // dd($errorMessage);

                return redirect()->back()->with('error', 'Farm API request failed: '. $errorMessage);
                return $errorMessage;
            } else {
                Log::info('farm order change status to delivered: ' . $reference_number );
            }

        } catch (RequestException $e) {
            // Handle Guzzle HTTP request exceptions
            return redirect()->back()->with('error', 'Farm API request failed');
        } catch (Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'Farm API request failed');
        }
       
    }

    public function import(Request $request)
    {
        $this->authorize('checkType', [User::class, $request->work_type]);
        $work_type = $request->work_type;
        $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();


        if ($request->work_type == 1 && in_array('show_order', app('User_permission'))){

        return view('admin.orders.import', compact('work_type', 'clients'));
     
        } else {
            return redirect(url(Auth()->user()->user_type));
        }

    }

    public function placeـorder_excel_to_db(Request $request)
    {

        try {
            $userid = $request->user_id;
            $user = User::where('id', $userid)->first();
            $file = 'excel/admin/'.$request->file('import_file')->hashName();
            $filePath = $request->file('import_file')->storeAs('public', $file);

            dispatch(new ImportOrdersFromExcelAdmin($filePath, $user));

            return redirect()->back()->with('success', 'Data imported successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error during import');
        }

    }

    public function print_invoices(Request $request)
    {

        $request['order_id'] = explode(',', $request['order_id'][0]);
        $request['order_id'] = $this->array_remove_by_value($request['order_id'], 'on');

        $request->validate([
            'order_id' => 'required|array',
            'order_id.*' => 'required|numeric|distinct',
        ]);

        $orders = Order::whereIn('id', $request['order_id'])->get();

        //for ($i = 0; $i < $orders; $i++) {}
        return view('admin.orders.print', compact('orders'));
    }

    public function run_sheet(request $request)
    {
        $order = Order::findOrFail($request->id);

        return view('admin.orders.run_sheet_pdf', compact('order'));
    }

    public function scan()
    {

        return view('admin.orders.scan');
    }

    public function checkOrderExists(Request $request)
    {
        return response()->json(['exists' => true]);
        // $orderID = $request->input('orderID');

        // // Check if the order exists in the database
        // $order = Order::where('order_id', $orderID)->first();

        // // Return JSON response indicating if the order exists
        // if ($order) {
        //     return response()->json(['exists' => true, 'status' => $order->status]);
        // } else {
        //     return response()->json(['exists' => false]);
        // }
    }

    public function getOrderStatus(Request $request)
    {
        $orderIDs = $request->input('orderIDs');

        // Retrieve order status from the database
        $orders = Order::whereIn('id', $orderIDs)->pluck('id', 'status_id');

        // Return JSON response with order status
        return response()->json($orders);
    }

    public function changeStatus(Request $request)
    {
        $orderIDs = $request->input('orderIDs');

        foreach ($orderIDs as $orderID) {
            // Update order status as per your requirement
            Order::where('id', $orderID)->update(['status' => 'Completed']);
        }

        return response()->json(['message' => 'Status changed successfully']);
    }

    public function unassignDelegate($id)
    {
        $order=Order::find($id);
        $order->update(['delegate_id' => null]); 

        return redirect()->back()->with('success', trans('admin_message.Delegate unassigned successfully'));
    }


    public function quickSearch($orders, $search)
    {
        $orders = $orders->where(function ($query) use ($search) {
            $query->where('order_id', 'LIKE', '%' . $search . '%')
                ->orWhere('tracking_id', 'LIKE', '%' . $search . '%')
                ->orWhere('pickup_date', 'LIKE', '%' . $search . '%')
                ->orWhere('sender_notes', 'LIKE', '%' . $search . '%')
                ->orWhere('number_count', 'LIKE', '%' . $search . '%')
                ->orWhere('reference_number', 'LIKE', '%' . $search . '%')
                ->orWhere('receved_name', 'LIKE', '%' . $search . '%')
                ->orWhere('receved_phone', 'LIKE', '%' . $search . '%')
                ->orWhere('receved_email', 'LIKE', '%' . $search . '%')
                ->orWhere('receved_address', 'LIKE', '%' . $search . '%')
                ->orWhere('receved_address_2', 'LIKE', '%' . $search . '%')
                ->orWhere('receved_notes', 'LIKE', '%' . $search . '%')
                ->orWhere('order_contents', 'LIKE', '%' . $search . '%')
                ->orWhere('amount', 'LIKE', '%' . $search . '%')
                ->orWhere('call_count', 'LIKE', '%' . $search . '%')
                ->orWhere('whatApp_count', 'LIKE', '%' . $search . '%')
                ->orWhere('is_finished', 'LIKE', '%' . $search . '%')
                ->orWhere('amount_paid', 'LIKE', '%' . $search . '%')
                ->orWhere('order_weight', 'LIKE', '%' . $search . '%')
                ->orWhere('over_weight_price', 'LIKE', '%' . $search . '%')
                ->orWhereHas('senderCity', function ($query) use ($search) {
                    $query->where('title_ar', 'LIKE', '%' . $search . '%')->orWhere('title', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('status', function ($query) use ($search) {
                    $query->where('title_ar', 'LIKE', '%' . $search . '%')->orWhere('title', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('recevedCity', function ($query) use ($search) {
                    $query->where('title_ar', 'LIKE', '%' . $search . '%')->orWhere('title', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('store_name', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('delegate', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                });
        });
        return $orders;
    }

    private function checkAymakanCities($order, $service_provider_id){

        // Send a request to fetch the list of cities
        $response = Http::get('https://api.aymakan.net/v2/cities');

        // Check if the request was successful
        if ($response->successful()) {
            // Extract city names from the response
            $cities = collect($response->json()['data']['cities'])->pluck('city_en');
            // dd($cities);

            // Extract received cities from the order
            $receivedCity = $order->recevedCity->title;            

            // Check if both sender and received cities exist in the list of cities
            $isReceivedCityValid = $cities->contains($receivedCity);

            if ($isReceivedCityValid) {                
                $this->aymakanApis($order, $service_provider_id);
            } else {
              
                return response()->json(['error' => 'Invalid received city'], 400);
            }
        } else {
           
            return response()->json(['error' => 'Failed to fetch cities'], $response->status());
        }

    }

    private function shortage_quenteny_from_stock($orderID)
    {
        $order=Order::findOrFail(($orderID));
        $OrderGoods=OrderGoods::where('order_id',$order->id)->get();
        foreach ($OrderGoods as $i => $OrderGood) {
                        $good = Good::find($OrderGood->good_id);
                            // تحديد الكمية المطلوبة من الطلب
                            $requiredQuantity = $OrderGood->number;
    
                            // استرجاع الحزم بترتيب تصاعدي للعدد
                            $packages = Client_packages_good::where('good_id', $good->id)
                                ->where('client_id', $order->user_id)
                                ->orderBy('number', 'ASC')
                                ->get();
    
                            foreach ($packages as $package) {
                                // إذا كانت الكمية المطلوبة أكبر من 0
                                if ($requiredQuantity > 0) {
                                    // حساب الفرق بين الكمية الموجودة في الحزمة والكمية المطلوبة
                                    $difference = $package->number - $requiredQuantity;
                                    if ($difference >= 0) {
                                        // إذا كان الفرق أكبر من أو يساوي 0، تحديث عدد الحزمة وتقليل الكمية المطلوبة إلى 0
                                        $package->number = $difference;
                                        $Packages_historiy=new Packages_history();
                                        $Packages_historiy->Client_packages_good=$package->id;
                                        $Packages_historiy->number=$requiredQuantity;
                                        $Packages_historiy->type=2;
                                        $Packages_historiy->order_id=$order->id;
                                        $Packages_historiy->user_id=Auth()->user()->id;
                                        $Packages_historiy->save();
                                        $requiredQuantity = 0;

                                    } else {
                                        // إذا كان الفرق سالبًا، تقليل الكمية المطلوبة وتحديث عدد الحزمة إلى 0
                                        $Packages_historiy=new Packages_history();
                                        $Packages_historiy->Client_packages_good=$package->id;
                                        $Packages_historiy->number=$package->number;
                                        $Packages_historiy->type=2;
                                        $Packages_historiy->order_id=$order->id;
                                        $Packages_historiy->user_id=Auth()->user()->id;
                                        $Packages_historiy->save();
                                        $requiredQuantity -= $package->number;
                                        $package->number = 0;

                                        // calculate expired date for subscription for pallet
                                    }
                                    $package->save();
                                 
                                } else {
                                    // إذا تم استيفاء الكمية المطلوبة، الخروج من الحلقة
                                    break;
                                }
                            }
                        // }
                        //
                        if ($packages->sum('number') <= 5) {
                            Notifications::addNotification('أوشك على النفاذ'.$good->title_en.'|'.$good->SKUS, 'يرجى اعادة شحن و تخزين المنتج: '.$good->title_en.'|'.$good->SKUS, 'good', $order->user_id, 'client');
                        }
                        if ($packages->sum('number') == 0) {
                            Notifications::addNotification('تم نفاذ المنتج'.$good->title_en.'|'.$good->SKUS, ' تم نفاذ المنتج من المخزن: '.$good->title_en.'|'.$good->SKUS, 'good', $order->user_id, 'client');
    
                        }
                    }
    }
    private function restocking_order_quantity_to_stock($orderID){
        $order=Order::findOrFail(($orderID));
        $OrderGoods=OrderGoods::where('order_id',$order->id)->get();
        foreach ($OrderGoods as $i => $OrderGood) {
                        $good = Good::find($OrderGood->good_id);
                            // تحديد الكمية المطلوبة من الطلب
                            $requiredQuantity = $OrderGood->number;
    
                            // استرجاع الحزم بترتيب تصاعدي للعدد
                            $packages = Client_packages_good::where('good_id', $good->id)
                                ->where('client_id', $order->user_id)
                                ->orderBy('number', 'ASC')
                                ->get();
    
                            foreach ($packages as $package) {
                                $history=Packages_history::where('Client_packages_good',$package->id)->where('order_id',$order->id)->where('type',2)->first();
                               

                                    if ($history!=null) {
                                        $package->number =$package->number+ $history->number;
                                        $package->save();
                                        $Packages_historiy=new Packages_history();
                                        $Packages_historiy->Client_packages_good=$package->id;
                                        $Packages_historiy->number=$history->number;
                                        $Packages_historiy->type=3;
                                        $Packages_historiy->order_id=$order->id;
                                        $Packages_historiy->user_id=Auth()->user()->id;
                                        $Packages_historiy->save();
                                    //   Notifications::addNotification('  تمت إعادة'.$good->title_en.'|'.$good->SKUS, ' إلى المخزن'.$good->title_en.'|'.$good->SKUS, 'good', $order->user_id, 'client');
                                    
                                    }
                      
                      
                        
                    }
                }

    }

    
    function FarmApiTest($reference_number)
    {

        try {
            $response = FarmTest::changeOrderStatusToDeliverd($reference_number);
            $data = json_decode($response, true);

            // Check if the operation was successful
            if(isset($data['status']) && isset($data['status']['success']) && $data['status']['success'] === false) {

                $errorMessage = $data['status']['otherTxt'];

                return response()->json([
                        'success' => 0,
                        'message' =>  'Farm API request failed: '. $errorMessage,
                    ]
                );
               
            } else {
                Log::info('farm order change status to delivered: ' . $reference_number);
                Log::info('farm order change status to delivered: ' . $response);
            }

        } catch (RequestException $e) {
                return response()->json([
                        'success' => 0,
                        'message' => __('Farm API request failed'),
                    ]
                );
            
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'message' => __('Farm API request failed'),
            ]
        );
        }
       
    }
    public function downloadMultiplePDFs(Request $request)
    {
        $orderIds = $request->input('order_ids'); // Array of order IDs
        $orders = Order::whereIn('id', $orderIds)->get();
    
        // Load the view and pass the orders data
        $pdf = PDF::loadView('website.show-pdf', compact('orders'));
    
        // Return the PDF as a download
        return $pdf->download('orders.pdf');
    }


    public function confirmSmb($id){
        $response = SmbExpress::confirmOrder($id);
        $data = json_decode($response->getBody(), true); // Parse response content as JSON
        log::info($data);
        $order=Order::where('consignmentNo',$id)->first();


        if ($response->getStatusCode() == 200) {
            $order->update([
                'tracking_url' => $data['data']['tracking_url'],
                'tracking_code' => $data['data']['tracking_code'],
                'public_pdf_label_url' => $data['data']['public_pdf_label_url'],

            ]);
        } 

        return redirect()->back()->with('success',trans('admin_message.the order is confirmed success'));

    }

    public function SmbExpressApis($order, $service_provider_id)
{
    $sender_city = Smb_city::where('title', $order->address->city->title)->first();
    $recive_city = Smb_city::where('title', $order->recevedCity->title)->first();
    
    if ($sender_city == null || $recive_city == null) {
        return redirect()->back()->with('error', 'SMB API request failed not accept this city');
    }

    try {
        $response = SmbExpress::createShipment($order);

        // Log the full response
        Log::info('SmbExpress API Response:', [
            'status' => $response->getStatusCode(),
            'body' => $response->getBody()->getContents()
        ]);

        $data = json_decode($response->getBody(), true); // Parse response content as JSON
            Log::info($data);
        if ($response->getStatusCode() == 200) {
            $order->update([
                'service_provider_id' => $service_provider_id,
                'consignmentNo' => $data['data']['id'],
            ]);

            Notifications::addNotification(
                'طلب شحن جديد',
                'تم اضافة طلب شحن جديد الي حسابك : ' . $order->order_id,
                'order',
                $service_provider_id,
                'service provider',
                $order->id
            );
        }
    } catch (\Exception $e) {
        // Log any exceptions
        Log::error('Error in SmbExpress API call:', ['exception' => $e]);

        return redirect()->back()->with('error', 'An error occurred while processing the SMB API request.');
    }
}


    //  function SmbExpressCancelOrder($order, $service_provider_id) {
    //     $consignmentNo = $order->consignmentNo;

    //     $data = SmbExpress::cancelOrder($consignmentNo);

    //  }

     function SmbExpressCancelOrder($order, $service_provider_id) {
        $consignmentNo = $order->consignmentNo;
    
        // Log the request to cancel the order
        Log::info('Requesting cancellation of order', [
            'consignmentNo' => $consignmentNo,
            'service_provider_id' => $service_provider_id,
        ]);
    
        try {
            // Call the cancelOrder method
            $response = SmbExpress::cancelOrder($consignmentNo);
    
            // Log the response
            Log::info('Response from SmbExpress::cancelOrder', [
                'consignmentNo' => $consignmentNo,
                'response_status' => $response->getStatusCode(),
                'response_body' => (string) $response->getBody(),
            ]);
    
            return $response;
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error cancelling order with SmbExpress', [
                'consignmentNo' => $consignmentNo,
                'service_provider_id' => $service_provider_id,
                'error_message' => $e->getMessage(),
            ]);
    
            // Optionally, rethrow the exception or handle it as needed
            throw $e;
        }
    }


     function SmbExpressReturn($order, $service_provider_id) {
        $consignmentNo = $order->consignmentNo;

        $data = SmbExpress::returnOrder($consignmentNo);

     }

    
    
}
