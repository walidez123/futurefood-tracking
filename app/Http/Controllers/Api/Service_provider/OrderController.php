<?php

namespace App\Http\Controllers\Api\Service_provider;

use App\Events\OrderStatusUpdated;
use App\Helpers\Notifications;
use App\Http\Controllers\Controller;
use App\Models\Order;

use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\PushNotificationsTrait;
use App\Models\CompanyProviderStatuses;
use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{
    use PushNotificationsTrait;

    public function __construct()
    {
        $this->middleware('auth:api');

    }

    public function updateOrderStatus(Request $request)
    {
        $data = $request->json()->all();
        Log::info('Order Status Update SMP:', $data);



        $user = Auth::user();

        // Log::info('SMP UPDATE STATUS: ' . json_encode($request->all()));


        if ($user->user_type == 'service_provider') {
            $rules = [
                'event' => 'required',
                'tracking_code' => 'required|numeric',
                'status' => 'required|in:delivered,error,arrived,In_transit,shipped,failed',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->messages(),
                ]);
            }

            $order = Order::where('tracking_code', $request->tracking_code)->first();
            if($order==null)
            {
                return response()->json([
                    'message' => 'Something went wrong!',
                ], 500);

            }

            
            $company_status = CompanyProviderStatuses::where('company_id', $order->company_id)->where('provider_name','smb')->first();

            if ($request->status == "delivered") {
                $status_id = $company_status->delivered_id;

            } elseif ($request->status == "error" || $request->status == "failed" ) {

                $status_id = $company_status->closed_id;
                
            }
            elseif ($request->status == "shipped") {
                $status_id = $company_status->assigned_id;

                
            }elseif ($request->status == "In_transit") {

                $status_id = $company_status->en_route_id;
                
            }
            elseif ($request->status == "arrived") {

                $status_id = $company_status->en_route_id;
                
            }

            $status = Status::findOrFail($status_id);

            if ($order) {
                // call helper function here
                GloablChangeStatus($order, $status->id);

                //send webhook http request to provider if exist
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

}
