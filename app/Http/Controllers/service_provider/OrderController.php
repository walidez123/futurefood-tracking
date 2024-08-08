<?php

namespace App\Http\Controllers\service_provider;

use App\Helpers\ClientTransactions;
use App\Helpers\Notifications;
use App\Helpers\OrderHistory;
use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Order;
use App\Models\Otp_code;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:show_order', ['only'=>'index', 'show']);
        // $this->middleware('permission:distribution_order', ['only'=>'edit', 'update']);
        // $this->middleware('permission:delete_order', ['only'=>'destroy']);
    }

    public function shipToday($work_type)
    {

        $user = auth()->user();
        $delegates = $user->Service_providerDelegate()->get();
        $Arraydelegates = $delegates->pluck('id')->toArray();
        if ($work_type == 1) {
            $delegates = $user->Service_providerDelegate()->where('work', 1)->get();

            $statuses = Status::where('company_id', $user->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();
            $orders = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->whereDate('pickup_date', date('Y-m-d'))
                ->where('work_type', $work_type)->paginate(25);
        } else {
            $delegates = $user->Service_providerDelegate()->where('work', $work_type)->get();

            $statuses = Status::where('company_id', $user->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();
            $orders = Order::whereIn('delegate_id', $Arraydelegates)->whereDate('created_at', date('Y-m-d'))->where('work_type', $work_type)->paginate(25);

        }

        return view('service_provider.orders.indexToday', compact('orders', 'work_type', 'statuses', 'delegates'));

    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $delegates = $user->Service_providerDelegate()->get();
        $Arraydelegates = $delegates->pluck('id')->toArray();
        $orders = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->get();

        $work_type = $request->work_type;
        $status_id = $request->status;

        $cities = City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->get();

        if ($request->exists('bydate')) {

            $orders = Order::whereIn('delegate_id', $Arraydelegates)->orderBy('pickup_date', 'DESC');
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
            $orders = $orders->where('work_type', $work_type)->orderBy('id', 'desc')->paginate(50);
            $clients = User::where('company_id', $user->company_id)->where('user_type', 'client')->where('work', $work_type)->get();
            $delegates = $user->Service_providerDelegate()->where('work', $work_type)->get();
            if ($work_type == 1) {
                $statuses = Status::where('company_id', $user->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($$work_type == 2) {
                $statuses = Status::where('company_id', $user->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

            }

            return view('service_provider.orders.index', compact('orders', 'work_type', 'clients', 'statuses', 'delegates', 'status_id', 'from', 'to', 'cities'));

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

            $search_order = $request->get('search_order');

            if ($from != null && $to != null) {
                if ($request->type == 'ship') {

                    $orders = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->whereDate('pickup_date', '>=', $from)
                        ->whereDate('pickup_date', '<=', $to);
                } else {
                    $orders = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to);
                }
            } else {
                $orders = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->orderBy('pickup_date', 'DESC');
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

            //bydate
            $orders = $orders->where('work_type', $work_type)->orderBy('id', 'desc')->paginate(50);
            $clients = User::where('company_id', $user->company_id)->where('user_type', 'client')->where('work', $work_type)->get();

            $delegates = $user->Service_providerDelegate()->where('user_type', 'delegate')->where('work', $work_type)->get();
            if ($work_type == 1) {
                $statuses = Status::where('company_id', $user->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 2) {
                $statuses = Status::where('company_id', $user->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

            }

            return view('service_provider.orders.index', compact('orders', 'work_type', 'clients', 'statuses', 'from', 'to', 'user_id', 'status_id', 'delegates', 'contact_status', 'delegate_id', 'cities', 'sender_city', 'receved_city', 'search', 'search_order'));
        } else {

            if ($status_id == null) {
                $orders = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->where('work_type', $work_type)->orderBy('id', 'desc')->paginate(25);

            } else {

                $orders = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->
                where('status_id', $status_id)->where('work_type', $work_type)->orderBy('id', 'desc')->paginate(25);
            }
            $clients = User::where('company_id', $user->company_id)->where('user_type', 'client')->where('work', $work_type)->get();
            $delegates = $user->Service_providerDelegate()->where('work', $work_type)->get();
            if ($work_type == 1) {

                $statuses = Status::where('company_id', $user->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 2) {
                $statuses = Status::where('company_id', $user->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 4) {
                $statuses = Status::where('company_id', $user->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();

            }

            return view('service_provider.orders.index', compact('orders', 'work_type', 'clients', 'statuses', 'delegates', 'cities'));
        }
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('serviceProviderShow', $order);

        $otps = Otp_code::where('order_id', $order->order_id)->orderBy('id', 'desc')->get();

        if ($order->work_type == 1) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('delegate_appear', 1)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

        } else {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->where('delegate_appear', 1)->orderBy('sort', 'ASC')->get();

        }

        if ($order) {

            return view('service_provider.orders.show', compact('order', 'statuses', 'otps'));
        } else {
            abort(404);
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
        $this->authorize('serviceProviderEdit', $order);

        if ($order) {
            $delegates = User::where('user_type', 'delegate')->get();
            $cities = City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->get();
            $user = User::where('id', $order->user_id)->first();
            $neighborhood = Neighborhood::where('id', $order->neighborhood_id)->first();
            $products = OrderProductwhere('order_id', $id)->get();
            $addresses = [];
            if (! empty($user)) {
                $addresses = $user->addresses()->get();
            }

            if ($order->work_type == 1) {
                return view('service_provider.orders.edit', compact('delegates', 'order', 'addresses', 'user', 'cities', 'neighborhood'));
            } else {
                return view('service_provider.orders.editRest', compact('delegates', 'order', 'addresses', 'user', 'cities', 'neighborhood', 'products'));

            }

        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {

        $order = Order::findOrFail($id);
        $order->update($request->all());
        if ($request->product_name) {
            OrderProduct::where('order_id', $id)->delete();

            foreach ($request->product_name as $i => $product_name) {
                $order_products = new OrderProduct();
                $order_products->product_name = $product_name;
                $order_products->size = $request->size[$i];
                $order_products->price = $request->price[$i];
                $order_products->number = $request->number[$i];
                $order_products->order_id = $order->id;
                $order_products->save();
            }

        }

        //
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
        return redirect()->route('service_provider_orders.index', ['work_type' => $order->work_type])->with($notification);
    }

    public function distribute(Request $request)
    {

        $request->validate([

            'delegate_id' => 'required|numeric',
        ]);
        $delegate_id = $request->delegate_id;

        if ($request->type == 'data') {
            $orders = explode(',', $request['orders'][0]);
            $orders = $this->array_remove_by_value($orders, 'on');
        } else {
            $orders = $request['orders'];
        }

        if ($orders) {
            foreach ($orders as $order) {

                $orderRow = Order::where('id', $order)->first();
                $orderRow->update(['delegate_id' => $delegate_id]);
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

    public function history($id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('serviceProviderHistory', $order);

        if ($order) {

            $histories = $order->history()->get();

            return view('service_provider.orders.history', compact('histories', 'order'));
        } else {
            abort(404);
        }

    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        $this->authorize('serviceProviderDelete', $order);

        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    public function createReturnOrder(Order $order)
    {
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
            'status_id' => $order->user->default_status_id,
            'provider' => $order->provider,
            'provider_order_id' => $order->provider_order_id,
            'is_returned' => 1,
        ]);
        $order = $returnOrder;
        OrderHistory::addToHistory($returnOrder->id, $returnOrder->user->default_status_id);
        Notifications::addNotification('طلب شحن مرتجع', 'تم اضافة طلب شحن مرتجع جديد برقم  : '.$returnOrder->order_id, 'order', null, 'admin');

        return view('service_provider.orders.show', compact('order'));
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
            // call helper function here
            $order->update([
                'status_id' => $status_id,
            ]);
            ClientTransactions::addToClientTransactions($order);
            OrderHistory::addToHistory($order->id, $status_id);
            dispatch(new \App\Jobs\UpdateOrderStatusInProvider($order))->delay($i + 5);
            // GloablChangeStatus($order,$status_id);
        }

        $notification = [
            'message' => '<h3>Order Status changed Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);

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
        return view('service_provider.orders.print', compact('orders'));

    }
}
