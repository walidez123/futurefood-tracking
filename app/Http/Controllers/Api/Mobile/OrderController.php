<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Helpers\Assignment;
use App\Helpers\ClientTransactions;
use App\Helpers\Notifications;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlinkStatusesResource;
use App\Http\Resources\CommentsResource;
use App\Http\Resources\OrderDelegateCollection;
use App\Http\Resources\OrderDelegateResource;
use App\Http\Resources\SearchResource;
use App\Http\Resources\StatusesorderResource;
use App\Http\Resources\StatusesResource;
use App\Http\Resources\StatusOrdersResource;
use App\Models\CompanyBlinkStatus;
use App\Models\Order;
use App\Models\Otp_code;
use App\Models\Status;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Services\Adaptors\Farm\Farm;
use Carbon\Carbon;


class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = Auth::user();
        $company = $user->company_setting;
        $status_id = $company->status_pickup;

        if ($user->user_type == 'delegate') {
            return new OrderDelegateCollection(($user->ordersDelegate()->where('work_type', 1)->paginate(500)));

        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function pickuporders()
    {
        $user = Auth::user();
        $company = $user->company_setting;
        $status_id = $company->status_pickup;

        if ($user->user_type == 'delegate') {
            return new OrderDelegateCollection(($user->ordersDelegatepickup()->where('work_type', 1)->where('status_id', $status_id)->paginate(10)));

        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function Daily()
    {
        // $user = Auth::user();
        // $today = (new \Carbon\Carbon)->today();

        // if ($user->user_type == 'delegate') {
        //     // dd(Order::where('delegate_id',$user->id)->where('work_type',1)->whereDate('updated_at',$today)->get());
        //     return new OrderDelegateCollection((Order::where('delegate_id', $user->id)->where('work_type', 1)->whereDate('created_at', $today)->paginate(10)));
        $user = Auth::user();
        $company = $user->company_setting;
        $status_id = $company->status_pickup;

        if ($user->user_type == 'delegate') {
            return new OrderDelegateCollection(($user->ordersDelegate()->where('work_type', 1)->paginate(500)));

        
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function dailyStoreStatusesOrdersWithCount()
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $statuses = StatusOrdersResource::collection(Status::where('delegate_appear', 1)->where('shop_appear', 1)->where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get());
            if (count($statuses) == 0) {
                return response()->json(
                    [
                        'success' => 0,

                        'message' => __('api_massage.No Statuses'),
                    ]
                );
            }

            return response()->json([
                'success' => 1,
                'statuses' => $statuses,

            ]);
        } else {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function dailyStoreStatusOrders(Request $request)
    {
        $user = Auth::user();

        if ($user->user_type == 'delegate') {
            $request->validate([

                'status_id' => 'required|numeric',
            ]);
            $status_id = $request->status_id;
            $status = Status::where('id', $status_id)->first();

          
            if ($status) {
                $today = (new \Carbon\Carbon)->today();
                
                return new OrderDelegateCollection(($user->ordersDelegate()->whereDate('updated_at', $today)->where('status_id',$status->id)->where('work_type', 1)->paginate(10)));

                
            } else {
                return response()->json([
                    'success' => 0,

                    'message' => __('api_massage.No Status With this Status id'),
                ]
                );
            }           

           
        } else {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function dailyRestaurantStatusOrders()
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([

                'status_id' => 'required|numeric',
            ]);
            $status_id = $request->status_id;
            $status = Status::where('id', $status_id)->first();

          
            if ($status) {
                $today = (new \Carbon\Carbon)->today();
                
                return new OrderDelegateCollection(($user->ordersDelegate()->whereDate('updated_at', $today)->where('status_id',$status->id)->where('work_type', 2)->paginate(10)));

                
            } else {
                return response()->json([
                    'success' => 0,

                    'message' => __('api_massage.No Status With this Status id'),
                ]
                );
            }           

           
        } else {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }
    

    public function statuses()
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $statuses = StatusesResource::collection(Status::where('delegate_appear', 1)->where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get());
            if (count($statuses) == 0) {
                return response()->json(
                    ['success' => 0,

                        'message' => __('api_massage.No Statuses'), ]
                );
            }

            return response()->json([
                'success' => 1,
                'statuses' => $statuses,

            ]);
        } elseif ($user->user_type == 'client') {
            if($user->work==4){
                
                $statuses = StatusesResource::collection(Status::where('fulfillment_appear',1)->where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get());

            }
            elseif($user->work==2){
                $statuses = StatusesResource::collection(Status::where('restaurant_appear', 1)->where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get());

            }
            elseif($user->work==1){
                $statuses = StatusesResource::collection(Status::where('shop_appear', 1)->where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get());

            }

            if (count($statuses) == 0) {
                return response()->json(
                    ['success' => 0,

                        'message' => __('api_massage.No Statuses'), ]
                );
            }

            return response()->json([
                'success' => 1,
                'statuses' => $statuses,

            ]);
        } else {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function blinkStatuses()
    {
        $user = Auth::user();
        // $host = request()->header('Referer');
        //     if ($user->domain == $host) {
        if ($user->user_type == 'client') {
            $statuses = BlinkStatusesResource::collection(CompanyBlinkStatus::where('company_id', $user->company_id)->get());

            if (count($statuses) == 0) {
                return response()->json(
                    ['success' => 0,

                        'message' => __('api_massage.No Statuses'), ]
                );
            }

            return response()->json([
                'success' => 1,
                'statuses' => $statuses,

            ]);
        } else {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

        // }else {
        //     return response()->json([
        //         'message' => 'Invalid Authentication',
        //     ], 503);
        // }

    }

    public function details(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
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
                $result = Order::where('order_id', $request->order_id)
                    ->get();
            }
            $result = OrderDelegateResource::collection($result);
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

    public function search(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $rules = [
                'order_id' => 'min:2|required_without_all:reference_number',
                'reference_number' => 'min:2|required_without_all:order_id',
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
                $result = Order::where('order_id', $request->order_id)->where('company_id',$user->company_id)
                    ->get();
            } elseif ($request->reference_number != null) {
                $result = Order::where('reference_number', $request->reference_number)->where('company_id',$user->company_id)
                    ->get();
            }
            $result = SearchResource::collection($result);
            if (count($result) > 0) {
                return response()->json([
                    'success' => 1,
                    'Order' => $result,
                ]);
            }

            return response()->json([
                'success' => 0,
                'message' => __('api_massage.No have results for your search'),
            ], 404);
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([

                'id' => 'required|numeric',
                'status_id' => 'required|numeric',
            ]);
            $id = $request->id;
            $status_id = $request->status_id;
            $status = Status::where('id', $status_id)->first();

            $checkOrder = Order::where('id', $id)
                ->where('delegate_id', $user->id)
                ->first();
            if ($checkOrder) {
                $order = Order::findOrFail($id);

                // if($checkOrder->status_id =! $checkOrder->user->userStatus->available_edit_status){
                //     return response()->json([
                //         'success' => 0,
    
                //         'message' => __("api_massage.Not Allowed"),
                //     ]);
                // }
                
                if ($status->otp_send_code == 1) {
                    $shouldSendOtp = false; // Default to not sending OTP

                    switch ($status->otp_status_send) {
                        case 'all':
                            $shouldSendOtp = true; // Send OTP for all orders
                            break;

                        case 'cc':
                            // Send OTP for orders paid with credit card
                            if ($order->amount_paid == 1) {
                                $shouldSendOtp = true;
                            }
                            break;

                        case 'cod':
                            // Send OTP for cash on delivery orders
                            if ($order->amount_paid == 0) {
                                $shouldSendOtp = true;
                            }
                            break;
                    }

                    if ($shouldSendOtp) {
                        $message = send_otp($order->order_id, $status->id, Auth()->user()->id);
                    }

                    return response()->json([
                        'success' => 1,

                        'message' => __("api_massage.A confirmation code has been sent to the customer's phone."),

                    ]
                    );
                } else {
                    // call helper function here
                    GloablChangeStatus($order, $status_id, $request->latitude, $request->longitude);
                    

                }

                //  Notifications::addNotification('تعديل علي طلب الشحن', ' تم تغيير حالة طلب الشحن رقم  : ' . $order->order_id . ' من ' . $oldStatus . ' الي ' . $order->status->title, 'order', $order->user_id, 'client', $order->id);

                return response()->json(
                    [
                        'success' => 1,

                        'message' => __('api_massage.Status changed successfully.'),

                    ]);
            } else {
                return response()->json([
                    'success' => 0,

                    'message' => __('api_massage.No order With this order number'),
                ]
                );
            }
        } else {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function comments(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([
                'order_id' => 'required|numeric',
            ]);
            $order_id = $request->order_id;
            $order = Order::findOrFail($order_id);
            $comments = CommentsResource::collection($order->comments()->get());
            if (count($comments) == 0) {
                return response()->json([
                    'success' => 0,
                    'message' => __('api_massage.No Comments found'),

                ]);
            }

            return response()->json([
                'success' => 1,
                'comments' => $comments,

            ]);
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function storeComment(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([
                'order_id' => 'required|numeric',
                'comment' => 'required',
            ]);
            $order = Order::findOrFail($request->order_id);
            $comment = $user->comments()->create($request->all());
            if ($comment) {
                Notifications::addNotification('تعليق جديد', ' تم اضافة تعليق جديد علي طلب الشحن رقم  : '.$order->order_id, 'comment', null, 'admin');

                return response()->json([
                    'success' => 1,
                    'message' => __('api_massage.Saved successfully'),
                ], 200);
            }
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function contactCount(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([
                'order_id' => 'required|numeric',
                'type' => 'required',
            ]);
            $order = Order::findOrFail($request->order_id);
            if ($request->type == 'call') {
                $update = $order->increment('call_count');

            } elseif ($request->type == 'whats') {
                $update = $order->increment('whatApp_count');

            } else {
                return response()->json([
                    'success' => 0,
                    'message' => __('api_massage.Type is not correct please choose one of them (call , whats)'),

                ], 503);
            }
            if ($update) {
                return response()->json([
                    'success' => 1,
                    'message' => 'Update Success',
                ], 200);
            }
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function updateList(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([
                'order_id' => 'required|array',
                'order_id.*' => 'required|numeric|distinct',
                'status_id' => 'required|numeric',
            ]);
            $orders = count($request['order_id']);
            $status_id = $request->status_id;

            $status = Status::where('id', $status_id)->first();

            for ($i = 0; $i < $orders; $i++) {

                $id = $request->order_id[$i];
              
                $order = Order::findOrFail($id);
             
                if ($status->otp_send_code == 1) {
                    $shouldSendOtp = false; // Default to not sending OTP

                    switch ($status->otp_status_send) {
                        case 'all':
                            $shouldSendOtp = true; // Send OTP for all orders
                            break;

                        case 'cc':
                            // Send OTP for orders paid with credit card
                            if ($order->amount_paid == 1) {
                                $shouldSendOtp = true;
                            }
                            break;

                        case 'cod':
                            // Send OTP for cash on delivery orders
                            if ($order->amount_paid == 0) {
                                $shouldSendOtp = true;
                            }
                            break;
                    }

                    if ($shouldSendOtp) {
                        $message = send_otp($order->order_id, $status->id, Auth()->user()->id);
                    }

                    return response()->json([
                        'success' => 1,

                        'message' => __("api_massage.A confirmation code has been sent to the customer's phone."),

                    ]
                    );
                }
            

                // call helper function here
                GloablChangeStatus($order, $status_id, $request->latitude, $request->longitude);
            }

            return response()->json([
                'success' => 1,
                'message' => __('api_massage.Status changed successfully.'),
            ]);

        } else {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function updateListV2(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([
                'status_id' => 'required|numeric',
            ]);

            $ordersId = $request->order_id;
            $Myorders = explode(',', $ordersId);
            $orders = count($Myorders);
            for ($i = 0; $i < $orders; $i++) {
                $id = $Myorders[$i];
                $status_id = $request->status_id;
                $checkOrder = Order::where('id', $id)
                    ->where('delegate_id', $user->id)
                    ->first();
                $order = Order::findOrFail($id);
                // call helper function here
                GloablChangeStatus($order, $status_id, $request->latitude, $request->longitude);
            }

            return response()->json([
                'success' => 1,
                'message' => __('api_massage.Status changed successfully.'),
            ]);

        } else {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function pickup(Request $request)
    {

        $user = Auth::user();
        $company = $user->company_setting;
        $status_id = $request->status_id;

        if ($user->user_type == 'delegate') {
            $request->validate([
                'order_id' => 'required|array',
                'order_id.*' => 'required|numeric|distinct',
                'status_id' => 'required',
            ]);
            $orders = count($request['order_id']);

            $status = Status::where('id', $request->status_id)->first();
            if ($status == null) {
                return response()->json([
                    'success' => 0,
                    'message' => __('api_massage.Status not found'),
                ], 503);

            }
            $pdforder = [];
            for ($i = 0; $i < $orders; $i++) {

                $id = $request->order_id[$i];
                $checkOrder = Order::where('id', $id)
                    ->first();
                $order = Order::findOrFail($id);
                // OTP
                if ($status->otp_send_code == 1) {
                    $shouldSendOtp = false; // Default to not sending OTP

                    switch ($status->otp_status_send) {
                        case 'all':
                            $shouldSendOtp = true; // Send OTP for all orders
                            break;

                        case 'cc':
                            // Send OTP for orders paid with credit card
                            if ($order->amount_paid == 1) {
                                $shouldSendOtp = true;
                            }
                            break;

                        case 'cod':
                            // Send OTP for cash on delivery orders
                            if ($order->amount_paid == 0) {
                                $shouldSendOtp = true;
                            }
                            break;
                    }

                    if ($shouldSendOtp) {
                        $message = send_otp($order->order_id, $status->id, Auth()->user()->id);
                    }
                }
                // endotp

                // call helper function here
                GloablChangeStatus($order, $status_id, $request->latitude, $request->longitude);
                $pdforder[] = $order;
                

                // if ($order->assign_pickup != $user->id) {}
                    $order->update([
                        'assign_pickup' => $user->id,
                        'delegate_id'=>$user->id,

                    ]);
                Assignment::addToAssignment($order->id, $user->id, $order->status_id, $type = 1);

                

            }
            //

            $pdf = PDF::loadView('admin.pdf.order', compact('pdforder'));
            $name = 'order_'.Auth()->user()->name.'.pdf';
            $content = $pdf->download()->getOriginalContent();
            Storage::put('public/pdf/order/'.$name, $content);
            // Storage::disk('local')->makeDirectory('public/pdf/order');
            $path = 'public/storage/pdf/order/';
            // $pdf->save($path. $name);
            $url = url($path.$name);

            return response()->json([
                'success' => 1,
                'message' => __('api_massage.Status changed successfully.'),
                'url' => $url,
            ]);

        } else {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function otp_code(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'code' => 'required|numeric|min:4',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'success' => 0,
                'message' => $validator->messages(),
            ]);
        }
        $code = $request->code;
        $Otp_code = Otp_code::where('code', $code)->first();
        if (! $Otp_code) {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Faild code'),

            ], 500);
        }
        $now = now();
        // return $now;
        if ($Otp_code->validate_to < $now || $Otp_code->is_used == 1) {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Expired code'),

            ], 500);
        }
        $order_id = $Otp_code->order_id;
        $status_id = $Otp_code->status_id;
        $status = Status::where('id', $status_id)->first();

        $order = Order::where('order_id', $order_id)
            ->where('delegate_id', $user->id)
            ->first();
        if ($order) {
            $Otp_code->is_used = 1;
            $Otp_code->save();
            // $oldStatus = $order->status->title;
            GloablChangeStatus($order, $status_id, $request->latitude, $request->longitude);

            return response()->json([
                'success' => 1,

                'message' => __('api_massage.Status changed successfully.'),
            ]);
        } else {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.No order With this order number'),
            ]);
        }
    }

    public function real_image(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'real_image_confirm' => 'required|image|mimes:jpeg,png,jpg',
            'order_id' => 'required|min:2',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->messages(),
            ]);
        }
        $order_id = $request->order_id;
        $order = Order::where('order_id', $order_id)->where('delegate_id', $user->id)->first();
        if ($request->hasFile('real_image_confirm')) {
            $avatar = 'avatar/order/'.$request->file('real_image_confirm')->hashName();
            $uploaded = $request->file('real_image_confirm')->storeAs('public', $avatar);

        }
        if ($order) {
            $order->update([
                'real_image_confirm' => $avatar,
            ]);

            return response()->json([
                'success' => 1,

                'message' => __('api_massage.Saved successfully'),

            ]);
        } else {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.No order With this order number'),
            ]
            );
        }
    }

    public function payment_method(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'payment_method' => 'required|numeric',
            'order_id' => 'required|min:2',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->messages(),
            ]);
        }
        $order_id = $request->order_id;
        $order = Order::where('order_id', $order_id)->where('delegate_id', $user->id)->first();

        if ($order) {
            $order->update([
                'payment_method' => $request->payment_method,
            ]);

            return response()->json([
                'success' => 1,

                'message' => __('api_massage.Saved successfully'),
            ]);
        } else {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.No order With this order number'),
            ]);
        }
    }

    private function updateTransaction($order)
    {

        ClientTransactions::addToClientTransactions($order);

    }

    public function git_orders_status(request $request){

        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $request->validate([

                'status_id' => 'required|numeric',
            ]);
            $status_id = $request->status_id;
            $status = Status::where('id', $status_id)->first();

          
            if ($status) {
            
                return new OrderDelegateCollection(($user->ordersDelegate()->where('status_id',$status->id)->paginate(10)));


               
            } else {
                return response()->json([
                    'success' => 0,

                    'message' => __('api_massage.No Status With this Status id'),
                ]
                );
            }
        } else {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }
        
    }

    

}
