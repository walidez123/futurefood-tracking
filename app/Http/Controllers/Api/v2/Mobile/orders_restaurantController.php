<?php

namespace App\Http\Controllers\Api\v2\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order_resDelegateCollection;
use App\Http\Resources\OrderResResource;
use App\Models\Order;
use App\Models\User;
use App\Models\Status;
use App\Http\Resources\OrderDelegateCollection;


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
        if($user)
        {

        if ($user->user_type == 'delegate') {
            return new Order_resDelegateCollection(($user->ordersDelegate()->where('work_type', 2)->paginate(10)));

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

        if ($user->user_type == 'delegate') {


            return new Order_resDelegateCollection((Order::where('delegate_id',$user->id)->where('work_type',2)->whereDate('updated_at',$today)->get()));
            // dd($user->ordersDelegate()->PickupToday()->get());


        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function new()
    {
        $user = Auth::user();
        $user=User::find($user->id);
        $clients = User::where('user_type', 'client')->get();
        $defultclientstatus = [];

        foreach ($clients as $i => $client) {
            $defultclientstatus[$i] = $client->default_status_id;
        }

        if ($user->user_type == 'delegate') {
            return new Order_resDelegateCollection(($user->ordersDelegate()->where('work_type', 2)->whereIn('status_id', $defultclientstatus)->paginate(10)));

        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

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

            return new Order_resDelegateCollection(($user->ordersDelegate()->where('status_id', $request->status_id)->paginate(10)));

        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

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
            
                return new Order_resDelegateCollection(($user->ordersDelegate()->where('work_type',2)->where('status_id',$status->id)->paginate(10)));


               
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
