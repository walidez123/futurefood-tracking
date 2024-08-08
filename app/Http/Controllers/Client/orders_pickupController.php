<?php

namespace App\Http\Controllers\Client;

use App\Helpers\Notifications;
use App\Helpers\OrderHistory;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\AppSetting;
use App\Models\Good;
use App\Models\Pickup_order;
use App\Models\Pickup_orders_good;
use App\Models\Size;
use App\Models\User;
use App\Models\Warehouse_branche;
use App\Models\PaletteSubscription;
use App\Services\OrderAssignmentService;
use App\Traits\PushNotificationsTrait;
use Illuminate\Http\Request;
use Carbon\Carbon;


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
        $work = Auth()->user()->work;
        $user = Auth()->user();
        $company = $user->company_setting;
        if ($work == 1) {
            $status_id = $company->status_pickup;

        } else {
            $status_id = $company->status_pickup_res;

        }

        if ($request->exists('type')) {
            $from = $request->get('from');
            $to = $request->get('to');
            if ($request->type == 'ship') {
                $orders = Pickup_order::whereBetween('updated_at', [$from, $to])->where('user_id', Auth()->user()->id);
            } else {
                $orders = Pickup_order::whereBetween('updated_at', [$from, $to])->where('user_id', Auth()->user()->id);
            }

            $orders = $orders->orderBy('id','DESC')->paginate(50);

            return view('client.Fulfment_warehouse_orders_pickup.index', compact('orders', 'from', 'to'));

        } elseif ($request->exists('bydate')) {

            $orders = Pickup_order::where('user_id', Auth()->user()->id)->where('status_id', $status_id)->orderBy('pickup_date', 'DESC');

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
            $orders = $orders->orderBy('id','DESC')->paginate(50);

            return view('client.Fulfment_warehouse_orders_pickup.index', compact('orders', 'from', 'to'));

        } else {
            $orders = Pickup_order::where('user_id', Auth()->user()->id)->orderBy('id','DESC')->paginate(50);

            return view('client.Fulfment_warehouse_orders_pickup.index', compact('orders'));
        }
    }

    public function create()
    {
        $addresses = Address::where('user_id', Auth()->user()->id)->get();
        $goods = Good::where('client_id', Auth()->user()->id)->get();

        if (Auth()->user()->work == 3) {
            $Warehouse_branches = Warehouse_branche::where('company_id', Auth()->user()->company_id)->whereIn('work', [1, 3])->get();

        } elseif (Auth()->user()->work == 4) {
            $Warehouse_branches = Warehouse_branche::where('company_id', Auth()->user()->company_id)->whereIn('work', [2, 3])->get();

        }
        $sizes = Size::where('company_id', Auth()->user()->company_id)->get();

        return view('client.Fulfment_warehouse_orders_pickup.add', compact('addresses', 'goods', 'sizes', 'Warehouse_branches'));

    }

    public function store(request $request)
    {
        $user = Auth()->user();

        $request->validate([

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
        $orderData['work_type'] = Auth()->user()->work;
        $orderData['company_id'] = Auth()->user()->company_id;

        $trackId = $user->tracking_number_characters.'-'.uniqid();
        $orderData['tracking_id'] = $trackId;
        $orderData['status_id'] = $user->default_status_id;
        $orderData['user_id'] = $user->id;

        $order = new Pickup_order();

        $savedOrder = $order->create($orderData);
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
                $order_products = new Pickup_orders_good();
                $good=good::find($good_id);

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
        Notifications::addNotification('طلب إلتقاط جديد', 'تم اضافة طلب إلتقاط جديد الي حسابك : '.$order->order_id, 'order', '', 'client', $order->id);

        // $assignmentService = new OrderAssignmentService();
        // $assignmentService->assignToDelegate($savedOrder);
        // $assignmentService->assignToService_Provider($savedOrder);

        // if ($user != null) {

        //     //mob notification :)
        //     if ($savedOrder->delegate_id != null) {
        //         $user = User::findorfail($savedOrder->delegate_id);
        //         $token = $user->Device_Token;
        //         if ($token != null) {
        //             $title = 'تمت أضافة طلب جديد ';
        //             $body = 'طلب شحن جديد'.'تم اضافة طلب شحن جديد الي حسابك : '.$savedOrder->order_id.'order'.$user->id.'delegate'.$savedOrder->id;
        //             // call function that will push notifications :
        //             $this->sendNotification($token, $title, $body);
        //         }
        //     }
        // }

        // OrderHistory::addToHistory($savedOrder->id, $savedOrder->status_id);
        //  Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد برقم  : '.$savedOrder->order_id, 'order', null, 'admin', $savedOrder->id);
        $notification = [
            'message' => '<h3>Save Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('orders_pickup.index')->with($notification);

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
            ->where('user_id', Auth()->user()->id)
            ->first();
        $this->authorize('show_pickup', $order);

        if ($order) {
            return view('client.Fulfment_warehouse_orders_pickup.show', compact('order'));
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
        $order = Order::where('id', $id)
            ->where('user_id', Auth()->user()->id)
            ->first();

        if ($order) {
            $cities = City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->get();
            $region = Neighborhood::where('id', $order->region_id)->first();
            $user = Auth()->user();
            $addresses = $user->addresses()->get();
            if ($user->work == 1) {
                return view('client.Fulfment_warehouse_orders_pickup.edit', compact('cities', 'order', 'addresses', 'region'));
            } else {
                return view('client.Fulfment_warehouse_orders_pickup.editRest', compact('cities', 'order', 'addresses', 'region'));

            }
        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sender_city' => 'required',
            'sender_phone' => 'required|numeric',
            //   'sender_address'                    => 'required',
            // 'sender_address_2'                  => 'required',
            // 'pickup_date'                       => 'required',
            'receved_name' => 'required|min:5',
            'receved_phone' => 'required|numeric',
            'receved_city' => 'required',
            //  'receved_address'                   => 'required',
            //  'receved_address_2'                 => 'required',
        ]);

        $order = Order::findOrFail($id);
        $order->update($request->all());
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('orders.index')->with($notification);
    }

    public function history($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth()->user()->id)
            ->first();
        if ($order) {
            $histories = $order->clienthistory()->get();

            return view('client.Fulfment_warehouse_orders_pickup.history', compact('histories'));
        } else {
            abort(404);
        }
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    //

}
