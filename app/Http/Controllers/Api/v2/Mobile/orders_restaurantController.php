<?php

namespace App\Http\Controllers\Api\v2\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order_resDelegateCollection;
use App\Http\Resources\OrderResResource;
use App\Models\Order;
use App\Models\User;
use App\Models\Status;
use App\Models\Company_setting;
use App\Helpers\Notifications;

use App\Http\Resources\OrderDelegateCollection;
use App\Http\Resources\CommentsResource;



use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class orders_restaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = Auth::user();
        $user=User::find($user->id);
        $company_settings=Company_setting::where('company_id',$user->company_id)->first();
        if($user)
        {

        if ($user->user_type == 'delegate') {
            return new Order_resDelegateCollection(
                $user->ordersDelegate()
                    ->where('work_type', 2)
                    ->where('status_id','!=',$company_settings->status_res)
                    ->orderBy('updated_at', 'desc')
                    ->paginate(50)
            );
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }
    }else{
        return response()->json([
            'success' => 0,
            'message' => __('api_massage.Invalid Authentication'),
        ], 503);
    }

    }

    public function Daily()
    {
        $user = Auth::user();
        $today = (new \Carbon\Carbon)->today();
        $company_settings=Company_setting::where('company_id',$user->company_id)->first();


        if ($user->user_type == 'delegate') {


            return new Order_resDelegateCollection((Order::where('delegate_id',$user->id)->where('work_type',2)->where('status_id','!=',$company_settings->status_res)->orderBy('created_at', 'desc')->whereDate('created_at',$today)->paginate(50)));


        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    // public function new()
    // {
    //     $user = Auth::user();
    //     $user=User::find($user->id);
    //     $company_settings=Company_setting::where('company_id',$user->company_id)->first();

    //     $clients = User::where('user_type', 'client')->get();
    //     $defultclientstatus = [];

    //     foreach ($clients as $i => $client) {
    //         $defultclientstatus[$i] = $client->default_status_id;
    //     }

    //     if ($user->user_type == 'delegate') {
    //         return new Order_resDelegateCollection(($user->ordersDelegate()->where('work_type', 2)->where('status_id','!=',$company_settings->status_res)->orderBy('updated_at', 'desc')->whereIn('status_id', $defultclientstatus)->paginate(50)));

    //     } else {
    //         return response()->json([
    //             'success' => 0,
    //             'message' => __('api_massage.Invalid Authentication'),
    //         ], 503);
    //     }

    // }

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
            $result = OrderResResource::collection($result);
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

    public function status_order(Request $request)
    {
        $user = Auth::user();
        $user=User::find($user->id);

        if ($user->user_type == 'delegate') {
            $rules = [
                'status_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // Validation failed
                return response()->json([
                    'success' => 0,

                    'message' => $validator->messages(),
                ]);
            }

            return new Order_resDelegateCollection(($user->ordersDelegate()->orderBy('updated_at', 'desc')->where('status_id', $request->status_id)->paginate(50)));

        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }
    // 
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
                //
                // otp
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
                    GloablChangeStatus($order, $status_id, $request->latitude, $request->longitude,$request->note);

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
        $user=User::find($user->id);

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
            if($order==null)
            {
                return response()->json([
                    'success' => 0,
                    'message' => __('api_massage.No order With this order number'),
                ], 503);
            }
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
                $checkOrder = Order::where('id', $id)
                    ->where('delegate_id', $user->id)
                    ->first();
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
                GloablChangeStatus($order, $status_id, $request->latitude, $request->longitude,$request->note);
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
 
}
