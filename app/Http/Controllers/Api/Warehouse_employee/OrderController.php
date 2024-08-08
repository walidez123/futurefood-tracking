<?php

namespace App\Http\Controllers\Api\Warehouse_employee;

use App\Helpers\ClientTransactions;
use App\Helpers\Notifications;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlinkStatusesResource;
use App\Http\Resources\StatusesorderResource;
use App\Http\Resources\StatusesResource;
use App\Models\CompanyBlinkStatus;
use App\Models\Order;
use App\Models\Otp_code;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

   
    

    public function statuses()
    {
        $user = Auth::user();
        if ($user->user_type == 'admin') {
            $statuses = StatusesResource::collection(Status::where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get());
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

   
   
    public function updateOrderStatus(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'admin') {
            $request->validate([
                'order_id' => 'required|numeric',
                'status_id' => 'required|numeric',
            ]);
            $id = $request->order_id;
            $status_id = $request->status_id;
            $status = Status::where('id', $status_id)->first();

            $checkOrder = Order::where('id', $id)->first();
            if ($checkOrder) {
                $order = Order::findOrFail($id);
                ClientTransactions::addToClientTransactions($order);
               
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

    public function pickup(Request $request)
    {

        $user = Auth::user();
        $company = $user->company_setting;
        $status_id = $request->status_id;

        if ($user->user_type == 'admin') {
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
                ClientTransactions::addToClientTransactions($order);
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
            
            }

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

}
