<?php

namespace App\Http\Controllers\Api\v2\Mobile;

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
        $user=User::find($user->id);

        $company = $user->company_setting;
        $status_id = $company->status_pickup;

        if ($user->user_type == 'delegate') {
            return new OrderDelegateCollection(($user->ordersDelegate()->where('work_type', 1)->paginate(15)));

        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function searchOrders(Request $request)
    {
        $request->validate([

            'paid' => 'required|boolean',
        ]);
        $paid = $request->paid;

        $user = Auth::user();
        $orders = $user->ordersDelegate()->where('work_type', 1);

        if ($paid != null) {
            if ($paid == 0) {
                $orders->where('amount_paid', 0);
            } else {
                $orders->where('amount_paid', 1);
            }
        }

        if ($user->user_type == 'delegate') {
            return new OrderDelegateCollection(($orders->paginate(15)));

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
        $user=User::find($user->id);

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
        $user = Auth::user();
        $today = (new \Carbon\Carbon)->today();

        $user = Auth::user();
        $user=User::find($user->id);

        $company = $user->company_setting;
        $status_id = $company->status_pickup;

        if ($user->user_type == 'delegate') {
            return new OrderDelegateCollection(($user->ordersDelegate()->where('work_type', 1)->whereDate('updated_at', $today)->paginate(50)));

        
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function Dailystatus()
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $statuses = StatusesorderResource::collection(Status::where('delegate_appear', 1)->where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get());
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

    
    public function dailyStoreStatusOrders()
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $statuses = StatusesorderResource::collection(Status::where('delegate_appear', 1)->where('shop_appear', 1)->where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get());
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

    public function dailyRestaurantStatusOrders()
    {
        $user = Auth::user();
        if ($user->user_type == 'delegate') {
            $statuses = StatusesorderResource::collection(Status::where('delegate_appear', 1)->where('restaurant_appear', 1)->where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get());
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
            
            if($user->work == 4)
                {$statuses = StatusesResource::collection(Status::where('fulfillment_appear', 1)->where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get()); }
            if($user->work == 2)
                {$statuses = StatusesResource::collection(Status::where('restaurant_appear', 1)->where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get()); }
            
            else{ $statuses = StatusesResource::collection(Status::where('shop_appear', 1)->where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get());
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
                $result = Order::where('order_id', $request->order_id)
                    ->get();
            } elseif ($request->reference_number != null) {
                $result = Order::where('reference_number', $request->reference_number)
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

                if ($order->assign_pickup != $user->id) {
                    $order->update([
                        'assign_pickup' => $user->id,
                        'delegate_id'=>$user->id,

                    ]);
                    Assignment::addToAssignment($order->id, $user->id, $order->status_id, $type = 1);

                }

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
            
                return new OrderDelegateCollection(($user->ordersDelegate()->where('work_type',1)->where('status_id',$status->id)->paginate(10)));


               
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
