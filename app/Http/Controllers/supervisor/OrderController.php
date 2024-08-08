<?php

namespace App\Http\Controllers\supervisor;

use App\Helpers\ClientTransactions;
use App\Helpers\Notifications;
use App\Helpers\OrderHistory;
use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\City;
use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use App\ProvidersIntegration\Salla\UpdateOrderStatus;
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
        $delegates = $user->SupervisorDelegate()->get();
        $Arraydelegates = $delegates->pluck('delegate_id')->toArray();
        if ($work_type == 1) {
            $orders = Order::whereIn('delegate_id', $Arraydelegates)->whereDate('pickup_date', date('Y-m-d'))->where('work_type', $work_type)->get();
        } else {
            $orders = Order::whereIn('delegate_id', $Arraydelegates)->whereDate('created_at', date('Y-m-d'))->where('work_type', $work_type)->get();

        }

        return view('supervisor.orders.indexToday', compact('orders'));

    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $delegates = $user->SupervisorDelegate()->get();
        $Arraydelegates = $delegates->pluck('delegate_id')->toArray();
        $orders = Order::whereIn('delegate_id', $Arraydelegates)->get();
        $work_type = $request->work_type;

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
            $delegates = User::whereIn('id', $Arraydelegates)->where('work', $work_type)->get();
            if ($work_type == 1) {
                $statuses = Status::where('company_id', $user->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($$work_type == 2) {
                $statuses = Status::where('company_id', $user->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

            }

            return view('supervisor.orders.index', compact('orders', 'work_type', 'clients', 'statuses', 'delegates', 'status_id', 'from', 'to', 'cities'));

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

                    $orders = Order::whereIn('delegate_id', $Arraydelegates)->whereDate('pickup_date', '>=', $from)
                        ->whereDate('pickup_date', '<=', $to);
                } else {
                    $orders = Order::whereIn('delegate_id', $Arraydelegates)->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to);
                }
            } else {
                $orders = Order::whereIn('delegate_id', $Arraydelegates)->orderBy('pickup_date', 'DESC');
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

            $delegates = User::whereIn('id', $Arraydelegates)->where('work', $work_type)->get();
            if ($work_type == 1) {
                $statuses = Status::where('company_id', $user->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 2) {
                $statuses = Status::where('company_id', $user->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

            }

            return view('supervisor.orders.index', compact('orders', 'work_type', 'clients', 'statuses', 'from', 'to', 'user_id', 'status_id', 'delegates', 'contact_status', 'delegate_id', 'cities', 'sender_city', 'receved_city', 'search', 'search_order'));
        } else {

            $orders = Order::whereIn('delegate_id', $Arraydelegates)->where('work_type', $work_type)->orderBy('id', 'desc')->paginate(50);
            $clients = User::where('company_id', $user->company_id)->where('user_type', 'client')->where('work', $work_type)->get();
            $delegates = User::whereIn('id', $Arraydelegates)->where('work', $work_type)->get();
            if ($work_type == 1) {
                $statuses = Status::where('company_id', $user->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

            } elseif ($work_type == 2) {
                $statuses = Status::where('company_id', $user->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

            }

            return view('supervisor.orders.index', compact('orders', 'work_type', 'clients', 'statuses', 'delegates', 'cities'));
        }
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('SupervisorShow', $order);

        if ($order) {
            return view('supervisor.orders.show', compact('order'));
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
        $this->authorize('SupervisorEdit', $order);

        if ($order) {
            $delegates = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'delegate')->get();
            $cities = City::get();
            $user = User::where('id', $order->user_id)->first();
            $addresses = [];
            if (! empty($user)) {
                $addresses = $user->addresses()->get();
            }

            return view('supervisor.orders.edit', compact('delegates', 'order', 'addresses', 'user', 'cities'));
        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {

        $order = Order::findOrFail($id);
        $order->update($request->all());
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
        return redirect()->route('supervisororders.index', ['work_type' => $order->work_type])->with($notification);
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
        $this->authorize('SupervisorHistory', $order);

        if ($order) {

            $histories = $order->history()->get();

            return view('supervisor.orders.history', compact('histories', 'order'));
        } else {
            abort(404);
        }

    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        $this->authorize('SupervisorDelete', $order);

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

        return view('supervisor.orders.show', compact('order'));
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

        //  dd( $request['order_id']);die();
        $request->validate([
            'order_id' => 'required|array',
            'order_id.*' => 'required|numeric|distinct',
            'status_id' => 'required|numeric',
        ]);
        $orders = count($request['order_id']);
        for ($i = 0; $i < $orders; $i++) {

            $id = $request->order_id[$i];
            $status_id = $request->status_id;
            //$checkOrder = Order::where('id', $id)->first();
            //$oldStatus = $checkOrder->status->title;
            $order = Order::findOrFail($id);
            $order->update([
                'status_id' => $status_id,
            ]);

            $updateOrderStatus = new UpdateOrderStatus();
            $updateOrderStatus->updateStatus($order);

            ClientTransactions::addToClientTransactions($order);

            OrderHistory::addToHistory($order->id, $request->status_id);
            //  Notifications::addNotification('تعديل علي طلب الشحن', ' تم تغيير حالة طلب الشحن رقم  : ' . $order->order_id . ' من ' . $oldStatus . ' الي ' . $order->status->title, 'order', $order->user_id, 'client', $order->id);
        }

        $notification = [
            'message' => '<h3>Order Status changed Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);

    }
}
