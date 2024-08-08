<?php

namespace App\Http\Controllers\Api\Store;

use App\Events\OrderStatusUpdated;
use App\Helpers\Notifications;
use App\Helpers\OrderHistory;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderClientCollection;
use App\Http\Resources\OrderClientResource;
use App\Http\Resources\OrderHistoryResource;
use App\Http\Resources\SearchResource;
use App\Models\Address;
use App\Models\AppSetting;
use App\Models\Order;
use App\Models\OrderGoods;
use App\Models\Good;
use App\Models\OrderProduct;
use App\Models\Status;
use App\Models\User;
use App\Services\OrderAssignmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\PushNotificationsTrait;
use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{
    use PushNotificationsTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'client' && $user->work != 4) {

            return new OrderClientCollection(($user->orders()->get()));
        } 
        elseif($user->user_type == 'client' && $user->work == 4) {return new OrderClientCollection(($user->orders()->paginate(25)));}
        // 
        else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }
    }

    public function store(Request $request)
    {
        // $host = request()->getHost();
        $user = Auth::user();

        if ($user->user_type == 'client') {
            // $host = request()->header('Referer');
            // if ($user->domain == $host) {
            $rules = [
                'store_address_id' => 'required|numeric',
                'reference_number' => 'nullable|numeric',
                'sender_city' => 'nullable|numeric',
                'sender_phone' => 'nullable|max:10|starts_with:05',
                'sender_address' => 'nullable|min:10',
                'sender_address_2' => 'nullable|min:10',
                'sender_notes' => 'nullable|min:3',
                'pickup_date' => 'required|date|date_format:Y-m-d|after:yesterday',
                'receved_name' => 'required|min:2',
                'receved_phone' => 'required|max:10|starts_with:05',
                'receved_city' => 'nullable|numeric',
                'receved_address' => 'nullable|min:10',
                'receved_address_2' => 'nullable|min:10',
                'order_contents' => 'nullable|min:3',
                'amount' => 'required|numeric',
                'amount_paid' => 'required|boolean',
                'number_count' => 'required|numeric',

            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // Validation failed
                return response()->json([
                    'message' => $validator->messages(),
                ]);
            }

            $storeAddressId = $request->input('store_address_id'); 
            $address = $user->addresses()->where('id', $storeAddressId)->first();

            if (!$address) {
                return response()->json([
                    'message' => 'Address not found!',
                ], 404);
            }
            
            if ($request->product_name != null) 
            {
                $request->validate([
                    'product_name' => 'required|array',
                    'size' => 'required|array',
                    'price' => 'required|array',
                    'number' => 'required|array',
                    'product_name.*' => 'required|string',
                    'size.*' => 'required|string',
                    'price.*' => 'required|numeric',
                    'number.*' => 'required|numeric',
                ]);
            }

            $appSetting = AppSetting::findOrFail(1);
            $user = Auth()->user();
            $orderData = $request->all();
            $order = new Order();
            $lastOrderID = $order->withTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
            $newOrderID = $lastOrderID + 1;
            $newOrderID = sprintf('%07s', $newOrderID);
            $orderId = $appSetting->order_number_characters.$newOrderID;
            $orderData['order_id'] = $orderId;
            $trackId = $user->tracking_number_characters.'-'.uniqid();
            $orderData['tracking_id'] = $trackId;
            $orderData['status_id'] = $user->default_status_id;
            $orderData['sender_phone'] = '966'.$request->sender_phone;
            $orderData['receved_phone'] = '966'.$request->receved_phone;
            $orderData['work_type'] = Auth()->user()->work;
            $orderData['company_id'] = Auth()->user()->company_id;
            $savedOrder = $user->orders()->create($orderData);
            // dd($orderData);
            $assignmentService = new OrderAssignmentService();
            $assignmentService->assignToDelegate($savedOrder->id);
            $assignmentService->assignToService_Provider($savedOrder->id);
            $savedOrder=Order::find($savedOrder->id);

                //mob notification :)
            if ($savedOrder->delegate_id != null) {
                try {
                    $user = User::findOrFail($savedOrder->delegate_id);
                    $token = $user->Device_Token;
                    if ($token != null) {
                        $title = 'تمت أضافة طلب جديد ';
                        $body = 'طلب شحن جديد'.'تم اضافة طلب شحن جديد الي حسابك : '.$savedOrder->order_id.' order'.$user->id.' delegate'.$savedOrder->id;
                        // call function that will push notifications :
                        $this->sendNotification($token, $title, $body);
                    }
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    \Log::error('User not found with ID: ' . $savedOrder->delegate_id);
                    // Handle the error as needed, e.g., notify the admin or take another action
                } catch (\Exception $e) {
                    \Log::error('An error occurred: ' . $e->getMessage());
                    // Handle the error as needed
                }
            }
            if ($request->goods) {

                $request->validate([
                    'good_id*' => 'required',
                    'number*' => 'required',
                ]);

                foreach ($request->goods as $i => $good) {
                    $order_goods = new OrderGoods();
                    $order_goods->good_id = $request->goods[$i];
                    $order_goods->number = $request->goods[$i];
                    $order_goods->order_id = $savedOrder->id;
                    $order_goods->save();
                }
            }
            if ($request->items) {
                foreach ($request->items as $i => $item) {
                    $order_products = new OrderProduct();
                    $order_products->product_name = $request->items[$i];
                    $order_products->size = $request->items[$i];
                    $order_products->price = $request->items[$i];
                    $order_products->number = $request->items[$i];
                    $order_products->order_id = $savedOrder->id;
                    $order_products->save();
                }
            }
            OrderHistory::addToHistory($savedOrder->id, $savedOrder->status_id);

            // OrderHistory::addToHistory($savedOrder->id, $savedOrder->status->title, $savedOrder->status->description, $user->default_status_id);
            Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد برقم  : '.$savedOrder->order_id, 'order', null, 'admin');

            return response()->json([
                'message' => 'Save Successfully',
                'order-id' => $savedOrder->id,
            ], 200);
            // } else {
            //     return response()->json([
            //         'message' => 'Invalid Authentication',
            //     ], 503);
            // }
        } else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }
    }
    public function fulfillmentOrderStore(Request $request)
    {
        $user = Auth::user();
        if ($user->work != 4) {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }
        if ($user->user_type == 'client') {
            
                $rules = [
                    'store_address_id' => 'required|numeric',
                    'reference_number' => 'nullable|numeric',
                    'sender_city' => 'nullable|numeric',
                    'sender_phone' => 'nullable|max:10|starts_with:05',
                    'sender_address' => 'nullable|min:10',
                    'sender_address_2' => 'nullable|min:10',
                    'sender_notes' => 'nullable|min:3',
                    'pickup_date' => 'required|date|date_format:Y-m-d|after:yesterday',
                    'receved_name' => 'required|min:5',
                    'receved_phone' => 'required|max:10|starts_with:05',
                    'receved_city' => 'required|numeric',
                    'receved_address' => 'nullable|min:10',
                    'receved_address_2' => 'nullable|min:10',
                    'order_contents' => 'nullable|min:3',
                    'amount' => 'required|numeric',
                    'amount_paid' => 'required|boolean',
                    'number_count' => 'required|numeric',
                    'product_SKUS' => 'nullable|array|min:1',
                    'product_SKUS.*' => 'nullable|string', // or other appropriate validation rules for SKU
                    'number' => 'nullable|array|min:1',
                    'number.*' => 'nullable|numeric|min:1', // or other appropriate validation rules for number
                ];
                $validator = Validator::make($request->all(), $rules);
    
                if ($validator->fails()) {
                    // Validation failed
                    return response()->json([
                        'message' => $validator->messages(),
                    ]);
                }
                if ($request->product_SKUS != null) 
                {
                    $request->validate([
                        'product_SKUS' => 'required|array',
                        'number' => 'required|array',
                        'product_SKUS.*' => 'required|string|exists:goods,SKUS',
                        'number.*' => 'required|numeric',
                    ]);
                }
    
                $appSetting = AppSetting::findOrFail(1);
                $user = Auth()->user();
                $orderData = $request->all();
                $order = new Order();
                $lastOrderID = $order->withTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
                $newOrderID = $lastOrderID + 1;
                $newOrderID = sprintf('%07s', $newOrderID);
                $orderId = $appSetting->order_number_characters.$newOrderID;
                $orderData['order_id'] = $orderId;
                $trackId = $user->tracking_number_characters.'-'.uniqid();
                $orderData['tracking_id'] = $trackId;
                $orderData['status_id'] = $user->default_status_id;
                $orderData['sender_phone'] = '966'.$request->sender_phone;
                $orderData['receved_phone'] = '966'.$request->receved_phone;
                $orderData['work_type'] = Auth()->user()->work;
                $orderData['company_id'] = Auth()->user()->company_id;
                $savedOrder = $user->orders()->create($orderData);
                $assignmentService = new OrderAssignmentService();
                $assignmentService->assignToDelegate($savedOrder->id);
                $assignmentService->assignToService_Provider($savedOrder->id);
                $savedOrder=Order::find($savedOrder->id);
    
                    //mob notification :)
                    if ($savedOrder->delegate_id != null) {
                        $user = User::findorfail($savedOrder->delegate_id);
                        $token = $user->Device_Token;
                        if ($token != null) {
                            $title = 'تمت أضافة طلب جديد ';
                            $body = 'طلب شحن جديد'.'تم اضافة طلب شحن جديد الي حسابك : '.$savedOrder->order_id.'order'.$user->id.'delegate'.$savedOrder->id;
                            // call function that will push notifications :
                            $this->sendNotification($token, $title, $body);
                        }
                    }
               
               
                if ($request->product_SKUS != null) 
                {
                    foreach ($request->product_SKUS as $i => $product_SKUS) {
                        $good = Good::where('SKUS',$product_SKUS)->where('client_id', $user->id)->first();
                        if($good){
                            $order_products = new OrderGoods();
                            $order_products->good_id = $good->id;
                            $order_products->number = $request->number[$i];
                            $order_products->order_id = $savedOrder->id;
                            $order_products->save();
                        }
                        else{
                            return response()->json([
                                    'message' => 'good not found',
                                ], 404);
                            }
                       
                    }
                }
    
                OrderHistory::addToHistory($savedOrder->id, $savedOrder->status->title, $savedOrder->status->description, $user->default_status_id);
                Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد برقم  : '.$savedOrder->order_id, 'order', null, 'admin');
    
                return response()->json([
                    'message' => 'Save Successfully',
                    'order-id' => $savedOrder->id,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Invalid Authentication',
                ], 503);
            }
       
        
    }
    

    public function resturantOrder(Request $request)
    {
        $user = Auth::user();
        if ($user->work == 2 && $user->user_type == 'client') {
            $rules = [
                'store_address_id' => 'required|numeric',
                'reference_number' => 'nullable|numeric',
                'sender_city' => 'nullable|numeric',
                'sender_phone' => 'nullable|max:10|starts_with:05',
                'sender_address' => 'nullable|min:10',
                'sender_address_2' => 'nullable|min:10',
                'sender_notes' => 'nullable|min:3',
                'pickup_date' => 'required|date|date_format:Y-m-d|after:yesterday',
                'receved_name' => 'required',
                'receved_phone' => 'required|max:10|starts_with:05',
                'receved_city' => 'required|numeric',
                'receved_address' => 'nullable|min:10',
                'receved_address_2' => 'nullable|min:10',
                'order_contents' => 'nullable|min:3',
                'amount' => 'required|numeric',
                'amount_paid' => 'required|boolean',
                'number_count' => 'required|numeric',
            ];
            $attributes = [
                'store_address_id' => 'Store Address ID',
                'reference_number' => 'Reference Number',
                'sender_city' => 'Sender City',
                'sender_phone' => 'Sender Phone',
                'sender_address' => 'Sender Address',
                'sender_address_2' => 'Sender Address 2',
                'sender_notes' => 'Sender Notes',
                'pickup_date' => 'Pickup Date',
                'receved_name' => 'Received Name',
                'receved_phone' => 'Received Phone',
                'receved_city' => 'Received City',
                'receved_address' => 'Received Address',
                'receved_address_2' => 'Received Address 2',
                'order_contents' => 'Order Contents',
                'amount' => 'Amount',
                'amount_paid' => 'Amount Paid',
                'number_count' => 'Number Count',
            ];
            
            $messages = [
                'required' => 'The :attribute field is required.',
                'numeric' => 'The :attribute must be a number.',
                'date' => 'The :attribute must be a valid date.',
                'date_format' => 'The :attribute must be in the format Y-m-d.',
                'after' => 'The :attribute must be a date after yesterday.',
                'min' => 'The :attribute must be at least :min characters.',
                'max' => 'The :attribute may not be greater than :max characters.',
                'starts_with' => 'The :attribute must start with :values.',
                'boolean' => 'The :attribute field must be true or false.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages)->setAttributeNames($attributes);
            
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->messages(),
                ]);
            }

            if ($request->product_name != null) 
            {
                $request->validate([
                    'product_name' => 'required|array',
                    'size' => 'required|array',
                    'price' => 'required|array',
                    'number' => 'required|array',
                    'product_name.*' => 'required|string',



                    'size.*' => 'required|string',
                    'price.*' => 'required|numeric',
                    'number.*' => 'required|numeric',
                ]);
            }

            $storeAddressId = $request->input('store_address_id'); 
            $address = $user->addresses()->where('id', $storeAddressId)->first();

            if (!$address) {
                return response()->json([
                    'message' => 'Address not found!',
                ], 404);
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
            $orderData['work_type'] = $user->work;
            $orderData['company_id'] = $user->company_id;
            $trackId = $user->tracking_number_characters.'-'.uniqid();
            $orderData['tracking_id'] = $trackId;
            $orderData['status_id'] = $user->default_status_id;
            $orderData['receved_phone'] = '966'.$request->receved_phone;
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

           

            if ($request->product_name != null) 
            {
                foreach ($request->product_name as $i => $product_name) {
                    $order_products = new OrderProduct();
                    $order_products->product_name = $product_name;
                    $order_products->size = $request->size[$i];
                    $order_products->price = $request->price[$i];
                    $order_products->number = $request->number[$i];
                    $order_products->order_id = $savedOrder->id;
                    $order_products->save();
                }
            }

          

            $branch = Address::find($request->branch_id);
            OrderHistory::addToHistory($savedOrder->id, $savedOrder->status->title, $savedOrder->status->description, $user->default_status_id);
            if ($savedOrder) {
                return response()->json([
                    'message' => 'Save Successfully',
                    'data' => [
                        'id' => $savedOrder->id,
                        'order_id' => $savedOrder->order_id,
                        'tracking_number' => $savedOrder->tracking_id,
                        'delegate name' => ! empty($savedOrder->delegate) ? $savedOrder->delegate->name : '',
                        'client_name' => $savedOrder->receved_name,
                        'client_phone' => $savedOrder->receved_phone,
                        // 'client_email'                      => $savedOrder->receved_email,
                        'client_city' => ! empty($savedOrder->recevedCity) ? $savedOrder->recevedCity->title : '',
                        'client_region' => ! empty($savedOrder->region) ? $savedOrder->region->title : '',
                        'address_details' => $savedOrder->receved_address_2,
                        'order_status' => $savedOrder->status->title,
                        'is_finished' => $savedOrder->is_finished,
                        'amount_paid' => $savedOrder->amount_paid,
                        'amount' => $savedOrder->amount,
                        'status' => $savedOrder->status->title,
                        'products' => $savedOrder->product->map(function ($product) {
                            return [
                                'id' => $product->id,
                                'product_name' => $product->product_name,
                                'size' => $product->size,
                                'number' => $product->number,
                                'price' => $product->price,
                            ];
                        }),

                    ],
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Somthing went wrong',
                ], 500);
            }

        } else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }
    }

    public function order_tracking(request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'client') {
            if ($request->tracking_number) {
                $trackId = $request->tracking_number;

                $order = Order::where('tracking_id', $trackId)->first();
                if ($order) {
                    $orderDetails = $order;
                    $orderHistory = OrderHistoryResource::collection($order->history()->get());

                    return response()->json($orderHistory);

                } else {
                    return response()->json([
                        'message' => 'There is no order for'.$trackId.'',
                    ], 503);
                }
            } else {
                return response()->json([
                    'message' => 'Should insert Tracking id',
                ], 503);
            }
        } else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }

    public function search(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'client') {
            $rules = [
                'order_id' => 'required|min:3',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // Validation failed
                return response()->json([
                    'message' => $validator->messages(),
                ]);
            }

            $result = Order::where('order_id', $request->order_id)
                ->Where('user_id', $user->id)
                ->get();
            $result = SearchResource::collection($result);
            if (count($result) > 0) {
                return response()->json([
                    'success' => 1,
                    'Order' => $result,
                ]);
            }

            return response()->json([
                'success' => 0,
                'message' => 'no have results for your search',
            ], 404);
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }

    //

    public function Daily()
    {
        $user = Auth::user();
        if ($user->user_type == 'client') {

            return new OrderClientCollection(($user->orders()->whereDate('updated_at', Carbon::now())->paginate(10)));
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }
    //

    
    public function updateOrderStatus(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'client') {
            $rules = [
                'order_id' => 'required|numeric',
                'status_id' => 'required|numeric',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->messages(),
                ]);
            }
            $order = Order::findOrFail($request->order_id);
            $status = Status::findOrFail($request->status_id);

            $order->update($request->all());
            if ($order) {
                // call helper function here
                GloablChangeStatus($order, $status->id);

                //send webhook http request to provider if exist
                if ($order->user->webhook_url) {
                    event(new OrderStatusUpdated($order->id, $status->id, $order->user->webhook_url));
                }

                return response()->json([
                    'message' => 'updated Successfully',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Something went wrong!',
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }


    public function updateOrderToPaid(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'client') {
            $rules = [
                'order_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->messages(),
                ]);
            }
            $order = Order::where('order_id', $request->order_id)->where('user_id', $user->id)->first();

            if ($order) {
                if ($order->amount_paid == 1){
                    Log::info('Order is already paid!' . $order->order_id);

                    return response()->json([
                        'success' => false,
                        'message' => 'Order is already paid!',
                    ], 200);
                }else{
                    $order->update(['amount_paid' => 1]);
                    Log::info('farm order changed to paid: ' . $order->order_id);
                   
                    return response()->json([
                        'success' => true,
                        'message' => 'Updated order to paid Successfully',
                    ], 200);
                }
                
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not exsit.',
                ], 404);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }
    public function details(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'client') {
            $rules = [
                'order_id' => 'min:2|required',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // Validation failed
                return response()->json([
                    'success' => 0,

                    'message' => $validator->messages(),
                ]);
            }

            if ($request->order_id != null) {
                $result = Order::where('id', $request->order_id)
                    ->get();
            }
            $result = OrderClientResource::collection($result);
            if (count($result) > 0) {
                return response()->json([
                    'success' => 1,
                    'Order' => $result,
                ]);
            }

            return response()->json([
                'success' => 0,
                'message' => __('api_massage.No order With this order number'),

            ], 404);
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }
}
