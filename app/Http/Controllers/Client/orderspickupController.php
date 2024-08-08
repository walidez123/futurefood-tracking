<?php

namespace App\Http\Controllers\Client;

use App\Helpers\Notifications;
use App\Helpers\OrderHistory;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\AppSetting;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Order;
use App\Traits\PushNotificationsTrait;
use Excel;
use Illuminate\Http\Request;

class orderspickupController extends Controller
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
                $orders = Order::whereBetween('pickup_date', [$from, $to])->where('user_id', Auth()->user()->id);
            } else {
                $orders = Order::whereBetween('created_at', [$from, $to])->where('user_id', Auth()->user()->id);
            }

            $orders = $orders->orderBy('updated_at', 'DESC')->get();

            return view('client.orders.index_pickup', compact('orders', 'from', 'to'));
        } elseif ($request->exists('bydate')) {

            $orders = Order::where('user_id', Auth()->user()->id)->where('status_id', $status_id)->orderBy('pickup_date', 'DESC');

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

            return view('client.orders.index_pickup', compact('orders', 'from', 'to'));

        } else {
            $orders = Order::where('user_id', Auth()->user()->id)->where('status_id', $status_id)->orderBy('pickup_date', 'DESC')->get();

            return view('client.orders.index_pickup', compact('orders'));
        }
    }

    public function receipt_date(Request $request)
    {
        $request['order_id'] = explode(',', $request['order_id'][0]);
        $request['order_id'] = $this->array_remove_by_value($request['order_id'], 'on');

        //  dd( $request['order_id']);die();
        $request->validate([
            'order_id' => 'required|array',
            'order_id.*' => 'required|numeric|distinct',
            'date' => 'required',
        ]);

        $orders = count($request['order_id']);
        for ($i = 0; $i < $orders; $i++) {

            $id = $request->order_id[$i];
            $order = Order::findOrFail($id);
            $order->update([
                'receipt_date_store' => $request->date,
            ]);
        }

        return redirect()->route('orderspickup.index');

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
        $order = Order::where('id', $id)
            ->where('user_id', Auth()->user()->id)
            ->first();
        if ($order) {
            return view('client.orders.show', compact('order'));
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
                return view('client.orders.edit', compact('cities', 'order', 'addresses', 'region'));
            } else {
                return view('client.orders.editRest', compact('cities', 'order', 'addresses', 'region'));

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

            return view('client.orders.history', compact('histories'));
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

    public function placeـorder_excel_to_db(Request $request)
    {
        $appSetting = AppSetting::findOrFail(1);
        $counter = 0;
        if ($request->hasFile('import_file')) {

            Excel::load($request->file('import_file')->getRealPath(), function ($reader) use ($appSetting, $request) {

                //     dd($reader->toArray()[0]['receved_city'] );die();

                if (! empty($reader->toArray())) {
                    foreach ($reader->toArray() as $row) {
                        // echo $row['receved_city'] .'<br>';

                        if ($row['receved_phone'] != '') {
                            $receved_city = City::where('title', $row['receved_city'])->first();
                            //  $sender_city = City::where('title',$row['sender_city'])->first();

                            $row['number_count'] = ! empty($row['number_count']) ? $row['number_count'] : 0;
                            $user = Auth()->user();
                            $orderData = $row;

                            $senderAddress = Address::where('user_id', auth()->user()->id)->first();

                            if ($senderAddress) {
                                $orderData['sender_city'] = $senderAddress->city_id;

                                $orderData['sender_phone'] = $senderAddress->phone;
                                $orderData['sender_address'] = $senderAddress->address;

                            }

                            /*else{
                            # code...
                            $notification = array(
                            'message' => '<h3>Imported does not stored. You must be add an address at least</h3>',
                            'alert-type' => 'danger');
                            }
                             */
                            if (! empty($receved_city)) {
                                $orderData['receved_city'] = $receved_city->id;
                            }

                            $orderData['number_count'] = intval($row['number_count']);
                            $order = new Order();
                            $lastOrderID = $order->withTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
                            $newOrderID = $lastOrderID + 1;
                            $newOrderID = sprintf('%07s', $newOrderID);
                            $orderId = $appSetting->order_number_characters.$newOrderID;
                            $orderData['order_id'] = $orderId;
                            $trackId = $user->tracking_number_characters.'-'.uniqid();
                            $orderData['tracking_id'] = $trackId;
                            $orderData['status_id'] = $user->default_status_id;

                            $orderData['pickup_date'] = date('y-m-d h:i:s');

                            $savedOrder = $request->user()->orders()->create($orderData);

                            OrderHistory::addToHistory($savedOrder->id, $user->default_status_id);
                        } else {
                            $counter++;
                        }

                    }
                    // die();
                }

            });
        }
        if ($counter > 0) {
            // code...
            $notification = [
                'message' => '<h3>Imported Successfully but there are some row not imported</h3>',
                'alert-type' => 'warning',
            ];
        } else {
            $notification = [
                'message' => '<h3>Imported Successfully</h3>',
                'alert-type' => 'success',
            ];
        }

        return redirect()->back();
    }

    public function array_remove_by_value($array, $value)
    {
        return array_values(array_diff($array, [$value]));
    }

    public function print_invoices(Request $request)
    {

        $request['order_id'] = explode(',', $request['order_id'][0]);
        $request['order_id'] = $this->array_remove_by_value($request['order_id'], 'on');

        //  dd( $request['order_id']);die();
        $request->validate([
            'order_id' => 'required|array',
            'order_id.*' => 'required|numeric|distinct',
        ]);
        $orders = Order::whereIn('id', $request['order_id'])->get();

        //for ($i = 0; $i < $orders; $i++) {}
        return view('client.orders.print', compact('orders'));
    }

    //
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
        $status = $order->user->default_status_id;
        if ($order->work_type == 1) {
            $status = Auth()->user()->company_setting->status_return_shop;
        } else {
            $status = Auth()->user()->company_setting->status_return_res;

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

        return view('client.orders.show', compact('order'));
    }
}
