<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Good;
use App\Models\Pickup_order;
use App\Models\Pickup_orders_good;
use App\Models\Size;
use App\Models\User;
use App\Models\Status;
use App\Models\PaletteSubscription;
use App\Models\Warehouse_branche;
use App\Traits\PushNotificationsTrait;
use Carbon\Carbon;
use App\Helpers\Notifications;
use Illuminate\Http\Request;

class orders_pickupController extends Controller
{
    use PushNotificationsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (($request->work_type == 3 && in_array('show_pickup_order_warehouse', app('User_permission'))) ||
             $request->work_type == 4 && in_array('show_pickup_order_fulfillment', app('User_permission'))) {

            $delegates = User::where('user_type', 'delegate')->where('is_active', 1)->where('company_id', Auth()->user()->company_id)->get();
            $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $request->work_type)->get();
            $warehouse_branches = Warehouse_branche::where('company_id', Auth()->user()->company_id)->whereIn('work', [$request->work_type,3])->get();
            if ($request->work_type == 3) {
                $warehouse_branches = Warehouse_branche::where('company_id', Auth()->user()->company_id)->whereIn('work', [1, 3])->get();
                $statuses = Status::where('company_id', Auth()->user()->company_id)->where('storehouse_appear', 1)->orderBy('sort', 'ASC')->get();


            } elseif ($request->work_type == 4) {
                $warehouse_branches = Warehouse_branche::where('company_id', Auth()->user()->company_id)->whereIn('work', [2, 3])->get();
                $statuses = Status::where('pick_up', 1)->get();

            }
            
            $work_type = $request->work_type;

            if ($request->exists('type')) {
                $from = $request->get('from');
                $to = $request->get('to');
                $user_id = $request->get('user_id');
                $status_id = $request->get('status_id');
                $warehouse_id = $request->get('warehouse_id');               
                $orders = Pickup_order::where('company_id', Auth()->user()->company_id);
                
                if ($from != null && $to != null) {

                        $orders =  $orders->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to);
                }
                if ($request->user_id != null) {
                    $orders->where('user_id', $user_id);
                }
                if ($request->status_id != null) {
                    $orders->where('status_id', $status_id);
                }
                if ($request->warehouse_id != null) {
                    $orders->where('warehouse_id', $warehouse_id);
                }
                if($request->delivery_service !=null)
                {
                    $orders->where('delivery_service', $request->delivery_service);

                }
                $orders=$orders->latest()->paginate(50);

                return view('admin.Fulfment_warehouse_orders_pickup.index', compact('orders', 'clients', 'statuses', 'warehouse_branches', 'from', 'to', 'work_type', 'statuses', 'delegates'));
            } else {
                $orders = Pickup_order::where('company_id', Auth()->user()->company_id)->where('work_type', $request->work_type)->latest()->paginate(50);

                return view('admin.Fulfment_warehouse_orders_pickup.index', compact('orders', 'clients', 'statuses', 'warehouse_branches', 'work_type', 'statuses', 'delegates'));
            }
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    public function create(request $request)
    {
        if (($request->work_type == 3 && in_array('add_pickup_order_warehouse', app('User_permission'))) ||
        $request->work_type == 4 && in_array('add_pickup_order_fulfillment', app('User_permission'))) {

            $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $request->work_type)->get();
            if ($request->work_type == 3) {
                $goods = Good::where('company_id', Auth()->user()->company_id)->where('client_id', null)->get();
                $Warehouse_branches = Warehouse_branche::where('company_id', Auth()->user()->company_id)->whereIn('work', [1, 3])->get();

            } elseif ($request->work_type == 4) {
                $goods = Good::where('company_id', Auth()->user()->company_id)->where('client_id', null)->get();
                $Warehouse_branches = Warehouse_branche::where('company_id', Auth()->user()->company_id)->whereIn('work', [2, 3])->get();

            }
            $sizes = Size::where('company_id', Auth()->user()->company_id)->get();
            $work_type = $request->work_type;

            return view('admin.Fulfment_warehouse_orders_pickup.add', compact('clients', 'goods', 'sizes', 'Warehouse_branches', 'work_type'));
        } else {
            return redirect(url(Auth()->user()->user_type));
        }

    }

    public function fetchClientGoods(Request $request, $clientId)
    {
        $clientGoods = Good::where('client_id', $clientId)->get();

        return response()->json(['goods' => $clientGoods]);
    }

    public function store(request $request)
    { 

        $request->validate([
            'user_id' => 'required',
            'warehouse_id' => 'required',
            'store_address_id' => 'required',
            'storage_types' => 'required',
        ]);

        $appSetting = AppSetting::findOrFail(1);

        $orderData = $request->all();
        $order = new Pickup_order();
        $lastOrderID = $order->withTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
        $newOrderID = $lastOrderID + 1;
        $lengthOfNewOrderId = strlen((string) $newOrderID);
        if ($lengthOfNewOrderId < 7) {
            for ($i = 0; $i < $lengthOfNewOrderId; $i++) {
                $newOrderID = '0'.$newOrderID;
            }
        }
        $orderId = 'PU'.$newOrderID;

        $orderData['order_id'] = $orderId;
        $orderData['status_id'] = 68;
        $user = User::where('id', $request->user_id)->first();

        $orderData['work_type'] = $user->work;
        $orderData['company_id'] = $user->company_id;

        $trackId = $user->tracking_number_characters.'-'.uniqid();
        $orderData['tracking_id'] = $trackId;
        // $orderData['status_id'] = $user->default_status_id;
        $orderData['user_id'] = $user->id;

        $order = new Pickup_order();

        $savedOrder = $order->create($orderData);
        // dd($savedOrder->delivery_service);
        if($savedOrder->delivery_service == 1 && $savedOrder->storage_types == 2)
        {
            if($savedOrder->pallete_number ){
                $cost = $user->UserCost->receive_palette * $savedOrder->pallete_number;
                
            }else{
                $cost = $user->UserCost->receive_palette;

            }
            $tax = $cost * $user->tax / 100;
            $total = $cost + $tax;

            $subscription = PaletteSubscription::create([
                'client_packages_goods_id' => null ,
                'order_id' => $savedOrder->id ,
                'user_id' => $user->id ,
                'transaction_type_id' => 20,
                'description' => "تكلفه استلام باليت وتوصيله" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax,
                'cost'=> $total,
                'start_date' => Carbon::now(),
                'type' => 'receive_palette',
            ]);
             
        }
        if ($request->good_id) {
            $request->validate([
                'good_id' => 'required',
                'expiration_date' => 'nullable',
                'number' => 'required',
            ]);
            $expire_date_counter=0;
            foreach ($request->good_id as $i => $good_id) {
                $good=good::find($good_id);
                $order_products = new Pickup_orders_good();
                $order_products->good_id = $good_id;
                if($good->has_expire_date==0)
                {
                    $order_products->expiration_date =null; // or any default value you see fit

                }else{ 
                    $order_products->expiration_date = $request->expiration_date[$expire_date_counter]; // or any default value you see fit
                    $expire_date_counter=$expire_date_counter+1;

                }
                $order_products->number = $request->number[$i];
                $order_products->order_id = $savedOrder->id;
                $order_products->save();
            }
        }
        $notification = [
            'message' => '<h3>Save Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('client_orders_pickup.index', ['work_type' => $user->work])->with($notification);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Pickup_order::where('id', $id)
            ->first();
        if (($order->work_type == 3 && in_array('show_pickup_order_warehouse', app('User_permission'))) ||
        $order->work_type == 4 && in_array('show_pickup_order_fulfillment', app('User_permission'))) {
            $this->authorize('adminShow_pickup', $order);
            $statuses = Status::where('pick_up', 1)->get();

            if ($order) {
                return view('admin.Fulfment_warehouse_orders_pickup.show', compact('order','statuses'));
            } else {
                abort(404);
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
        $order = Pickup_order::where('id', $id)->first();
        $this->authorize('adminShow_pickup', $order);

        if (($order->work_type == 3 && in_array('edit_pickup_order_warehouse', app('User_permission'))) ||
        $order->work_type == 4 && in_array('edit_pickup_order_fulfillment', app('User_permission'))) {
            if ($order) {
                $user = User::where('id', $order->user_id)->first();
                $addresses = [];
                if (! empty($user)) {
                    $addresses = $user->addresses()->get();
                }

                if ($order->work_type == 3) {
                    $goods = Good::where('company_id', Auth()->user()->company_id)->where('client_id', null)->get();
                    $Warehouse_branches = Warehouse_branche::where('company_id', Auth()->user()->company_id)->whereIn('work', [1, 3])->get();

                } elseif ($order->work_type == 4) {
                    $goods = Good::where('company_id', Auth()->user()->company_id)->where('client_id', null)->get();
                    $Warehouse_branches = Warehouse_branche::where('company_id', Auth()->user()->company_id)->whereIn('work', [2, 3])->get();

                }
                $sizes = Size::where('company_id', Auth()->user()->company_id)->get();

                return view('admin.Fulfment_warehouse_orders_pickup.edit', compact('order', 'addresses', 'goods', 'sizes', 'Warehouse_branches'));

            } else {
                abort(404);
            }
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'warehouse_id' => 'required',
            'store_address_id' => 'required',
            'storage_types' => 'required',
        ]);

        $order = Pickup_order::findOrFail($id);
        $order->update($request->all());
        if ($request->good_id) {
            $request->validate([
                'good_id' => 'required',
                'expiration_date' => 'required',
                'number' => 'required',
            ]);
            foreach ($request->good_id as $i => $good_id) {
                $order_products = new Pickup_orders_good();
                $order_products->good_id = $good_id;
                $order_products->expiration_date = $request->expiration_date[$i];
                $order_products->number = $request->number[$i];
                $order_products->order_id = $order->id;
                $order_products->save();
            }
        }
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('client_orders_pickup.index', ['work_type' => $order->work_type])->with($notification);
    }

    public function destroy($id)
    {
        $order = Pickup_order::where('id', $id)->first();
        if (($order->work_type == 3 && in_array('delete_pickup_order_warehouse', app('User_permission'))) ||
        $order->work_type == 4 && in_array('delete_pickup_order_fulfillment', app('User_permission'))) {
            Pickup_order::findOrFail($id)->delete();
            Pickup_orders_good::where('order_id', $id)->delete();

            $notification = [
                'message' => '<h3>Delete Successfully</h3>',
                'alert-type' => 'success',
            ];

            return back()->with($notification);
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    public function destroy_good($id)
    {
        Pickup_orders_good::findOrFail($id)->delete();

        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    public function array_remove_by_value($array, $value)
    {
        return array_values(array_diff($array, [$value]));
    }

    public function changeStatus(Request $request)
    {

        $request['order_id'] = explode(',', $request['order_id'][0]);
        // dd($request['order_id']);

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
            $order = Pickup_order::findOrFail($id);
            $order->update([
                'status_id' => $status_id,
            ]);

        }

        return back()->with('success', trans('admin_message.order_status_change_success'));

    }


    public function assignDelegate(Request $request)
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

                $orderRow = Pickup_order::where('id', $order)->first();
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


    public function print_invoices(Request $request)
    {

        $request['order_id'] = explode(',', $request['order_id'][0]);
        $request['order_id'] = $this->array_remove_by_value($request['order_id'], 'on');

        $request->validate([
            'order_id' => 'required|array',
            'order_id.*' => 'required|numeric|distinct',
        ]);

        $orders = Pickup_order::whereIn('id', $request['order_id'])->get();

        //for ($i = 0; $i < $orders; $i++) {}
        return view('admin.Fulfment_warehouse_orders_pickup.print', compact('orders'));
    }

}
