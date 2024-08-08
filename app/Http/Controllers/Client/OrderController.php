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
use App\Models\Packages_history;
use ZipStream\ZipStream;
use ZipStream\Option\Archive;
use ZipStream\Option\File;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class OrderController extends Controller
{
    use PushNotificationsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2(Request $request)
    {
        $parameterNames = $request->query->keys();

        $statusUrl = array_key_first($request->query->all());


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
                $orders = Order::where('is_returned',0)->whereBetween('pickup_date', [$from, $to])->where('user_id', Auth()->user()->id);
            } else {
                $orders = Order::where('is_returned',0)->whereBetween('created_at', [$from, $to])->where('user_id', Auth()->user()->id);
            }
            if ($request->status_id != null) {
                $orders->where('status_id', $status_id);
            }
            $orders = $orders->orderBy('updated_at', 'DESC')->paginate(50);
            return view('client.orders.index', compact('orders', 'statuses', 'from', 'to', 'status_id'));
        } elseif ($request->exists('bydate')) {

            $orders = Order::where('is_returned',0)->where('user_id', Auth()->user()->id)->where('status_id', $status)->orderBy('updated_at', 'DESC');
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

            return view('client.orders.index', compact('orders', 'statuses', 'status_id', 'from', 'to'));

        } else {

            $status = Status::where('company_id', Auth()->user()->company_id)->where('title', str_replace('_', ' ', $statusUrl))->first();
            if ($request->work_type) {
                $orders = Order::where('is_returned',0)->where('user_id', Auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(50);
            } else {
                $orders = Order::where('is_returned',0)->where('user_id', Auth()->user()->id)->where('status_id',$status->id)->orderBy('updated_at', 'DESC')->paginate(50);

            }

            return view('client.orders.index', compact('orders', 'statuses'));
        }
    }
    public function index(Request $request)
    {
        $parameterNames = $request->query->keys();
        $statusUrl = array_key_first($request->query->all());
        if(Auth()->user()->work == 1 )
        {
            $status = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear',1)->where('title', str_replace('_', ' ', $statusUrl))->first();


        }elseif(Auth()->user()->work == 2 ){

            $status = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear',1)->where('title', str_replace('_', ' ', $statusUrl))->first();

        }elseif(Auth()->user()->work == 3 ){
            $status = Status::where('company_id', Auth()->user()->company_id)->where('storehouse_appear',1)->where('title', str_replace('_', ' ', $statusUrl))->first();


        }elseif(Auth()->user()->work == 4 ){
            $status = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear',1)->where('title', str_replace('_', ' ', $statusUrl))->first();


        }
        if($status==null){
            $status_id=null;

        }else{
            $status_id=$status->id;
        }
       
        if ($request->exists('type'))
         {
            $from = $request->get('from');
            $to = $request->get('to');
          
            if ($request->type == 'ship') {
                $orders = Order::where('is_returned',0)->whereBetween('pickup_date', [$from, $to])->where('user_id', Auth()->user()->id);
            } else {
                $orders = Order::where('is_returned',0)->whereBetween('created_at', [$from, $to])->where('user_id', Auth()->user()->id);
            }
            if ($request->status_id != null) {
                $orders->where('status_id', $request->status_id);
            }
            $orders = $orders->orderBy('updated_at', 'DESC')->paginate(50);
            $status_id=$request->status_id;
            return view('client.orders.index', compact('orders', 'from', 'to', 'status_id'));
        } 
        else {

            if ($request->work_type) {
                $orders = Order::where('is_returned',0)->where('user_id', Auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(50);

            } else {
                $orders = Order::where('is_returned',0)->where('user_id', Auth()->user()->id)->where('status_id',$status->id)->orderBy('updated_at', 'DESC')->paginate(50);


            }


            return view('client.orders.index', compact('orders','status_id'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth()->user();
        $addresses = $user->addresses()->get();
        // dd($addresses);

        $cities = City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->get();
        $goods = Good::where('client_id', Auth()->user()->id)->get();

        if ($user->work == 1 || $user->work == 3 || $user->work == 4) {
            return view('client.orders.add', compact('addresses', 'cities', 'user', 'goods'));
        } else {
            return view('client.orders.addRest', compact('addresses', 'cities'));

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth()->user();

        if ($user->work == 2) {
            $request->validate([

                'receved_name' => 'required|min:2',
                'receved_phone' => 'required|max:10|starts_with:05',
                'receved_city' => 'nullable',
                'receved_address' => 'nullable',
                'receved_email' => 'nullable|email',
                'amount' => 'required|numeric',
            ]);
        } else {
            $request->validate([
                // 'sender_city' => 'required',
                'receved_name' => 'required|min:2',
                'receved_phone' => 'required|max:10|starts_with:05',
                'receved_city' => 'required',
                'receved_address' => 'nullable',
                'receved_email' => 'nullable|email',
                'amount' => 'required|numeric',
            ]);
        }

        if ($request->good_id) {
            foreach ($request->good_id as $i => $good_id) {
                $good = Good::find($good_id);
                $sum = $good->Client_packages_goods->sum('number');
                if ($sum < $request->number[$i]) {
                    return redirect()->back()->with('error', __('goods.This number of product is not available in stock'));
                }
            }
        }

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
        $orderData['work_type'] = Auth()->user()->work;
        $orderData['company_id'] = Auth()->user()->company_id;

        $trackId = $user->tracking_number_characters.'-'.uniqid();
        $orderData['tracking_id'] = $trackId;
        $orderData['status_id'] = $user->default_status_id;
        $orderData['receved_phone'] = '966'.$request->receved_phone;

        $savedOrder = $request->user()->orders()->create($orderData);
        if ($request->product_name) {
            $request->validate([
                'product_name' => 'required',
                'size' => 'required',
                'number' => 'required',
            ]);
            foreach ($request->product_name as $i => $product_name) {
                $order_products = new OrderProduct();
                $order_products->product_name = $product_name;
                $order_products->size = $request->size[$i];
                $order_products->number = $request->number[$i];
                $order_products->order_id = $savedOrder->id;
                $order_products->save();
            }
        }
        if ($request->good_id) {

            $request->validate([
                'good_id' => 'required',
                'number' => 'required',
            ]);
            foreach ($request->good_id as $i => $good_id) {
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

        $assignmentService = new OrderAssignmentService();
        $assignmentService->assignToDelegate($savedOrder->id);
        $assignmentService->assignToService_Provider($savedOrder->id);

          $savedOrder=Order::find($savedOrder->id);
            //mob notification :)
            if ($savedOrder->delegate_id != null) {
                $user = User::find($savedOrder->delegate_id);
                if($user!=null)
                {
                $token = $user->Device_Token;
                if ($token != null) {
                    $title = 'تمت أضافة طلب جديد ';
                    $body = 'طلب شحن جديد'.'تم اضافة طلب شحن جديد الي حسابك : '.$savedOrder->order_id.'order'.$user->id.'delegate'.$savedOrder->id;
                    // call function that will push notifications :
                    $this->sendNotification($token, $title, $body);
                }
                }
            }
        // CompanyTransactions::addToCompanyTransaction($savedOrder);
        OrderHistory::addToHistory($savedOrder->id, $savedOrder->status_id);
        //  Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد برقم  : '.$savedOrder->order_id, 'order', null, 'admin', $savedOrder->id);
        $notification = [
            'message' => '<h3>Save Successfully</h3>',
            'alert-type' => 'success',
        ];

        $orderCount = Order::where('user_id', Auth()->user()->id)->count();

        return redirect()->route('orders.index', ['work_type' => Auth()->user()->work])->with($notification);

    }

    public function show($id)
    {

        $order = Order::where('id', $id)
            ->where('user_id', Auth()->user()->id)
            ->first();
        $this->authorize('show', $order);

        if ($order) {
            if($order->is_returned==1)
            {
                return view('client.orders.show_return', compact('order'));

            }else{
                return view('client.orders.show', compact('order'));

            }

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
        // $this->authorize('edit', $order);

        $products = OrderProduct::where('order_id', $id)->get();

        if ($order) {
            $cities = City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->get();
            $neighborhood = Neighborhood::where('id', $order->neighborhood_id)->first();
            $user = Auth()->user();
            $addresses = $user->addresses()->get();
            if ($user->work == 1) {
                return view('client.orders.edit', compact('cities', 'order', 'addresses', 'neighborhood'));
            } else {
                return view('client.orders.editRest', compact('cities', 'order', 'addresses', 'neighborhood', 'products'));

            }
        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if ($order->work_type == 1) {
            $request->validate([
                'sender_city' => 'required',
                'receved_name' => 'required|min:5',
                'receved_phone' => 'required|numeric',
                'receved_city' => 'required',

            ]);
        } else {
            $request->validate([
                'receved_name' => 'required|min:5',
                'receved_phone' => 'required|numeric',
                'receved_city' => 'required',

            ]);

        }

        $order = Order::findOrFail($id);
        $order->update($request->all());
        OrderProduct::where('order_id', $id)->delete();
        if ($request->product_name) {

            foreach ($request->product_name as $i => $product_name) {
                $order_products = new OrderProduct();
                $order_products->product_name = $product_name;
                $order_products->size = $request->size[$i];
                $order_products->number = $request->number[$i];
                $order_products->order_id = $order->id;
                $order_products->save();
            }

        }
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('orders.index', ['work_type' => Auth()->user()->work])->with($notification);
    }

    public function history($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth()->user()->id)
            ->first();
        $this->authorize('history', $order);

        if ($order) {
            $histories = $order->clienthistory()->get();

            return view('client.orders.history', compact('histories', 'order'));
        } else {
            abort(404);
        }
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $this->authorize('delete', $order);

        $order->delete();

        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    public function delete_product($id)
    {
        $product=OrderProduct::find($id);
        $product->delete();
        return back();

    }

    public function placeـorder_excel_to_db(Request $request)
    {

        try {
            $user = auth()->user();
            $file = 'excel/client'.$request->file('import_file')->hashName();
            $filePath = $request->file('import_file')->storeAs('public', $file);
            // dd($filePath);
            // ImportOrdersFromExcel::dispatch($filePath)->onQueue('import');

            dispatch(new ImportOrdersFromExcel($filePath, $user));

            return redirect()->back()->with('success', 'Data imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->with('error', 'Error during import: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error during import');

        }

    }

    public function array_remove_by_value($array, $value)
    {
        return array_values(array_diff($array, [$value]));
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
            // 'reference_number'=>$order->reference_number,
            'store_address_id'=>$order->store_address_id,
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
            'payment_method'=>$order->payment_method,
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

        return redirect()->route('orders.show', $order->id);

        // return view('client.orders.show', compact('order'));
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

    public function downloadMultiplePDFs(Request $request)
    {
        $orderIds = $request->input('order_ids'); // Array of order IDs
        $orders = Order::whereIn('id', $orderIds)->get();
    
        // Load the view and pass the orders data
        $pdf = PDF::loadView('website.show-pdf', compact('orders'));
    
        // Return the PDF as a download
        return $pdf->download('orders.pdf');
    }
}
