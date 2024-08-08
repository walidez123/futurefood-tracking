<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('check_token');
    }

    public function check_token(Request $request)
    {
        $rules = [
            'token' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        } else {
            $user = User::where('api_token', $request->token)->first();
            if ($user) {
                return response()->json([
                    'success' => 1,
                    'token' => true,
                ]);
            } else {
                return response()->json([
                    'success' => 0,
                    'token' => false,
                ]);

            }

        }

    }

    public function notifications(request $request)
    {
        $user = auth()->user();
        if ($user) {
            if ($request->exists('unread') || ! $request->exists('readable')) {

                $notifications = Notification::where(function ($q) use ($user) {
                    $q->where('notification_to', $user->id);
                    $q->orWhere('notification_from', $user->id);
                })
                    ->Unread()
                    ->orderBy('order_id', 'DESC')
                    ->paginate(15);

            } elseif ($request->exists('readable')) {

                $notifications = Notification::where(function ($q) use ($user) {
                    $q->where('notification_to', $user->id);
                    $q->orWhere('notification_from', $user->id);
                })
                    ->read()
                    ->orderBy('order_id', 'DESC')
                    ->paginate(15);

            }

            return response()->json([
                'success' => 1,
                'total' => $notifications->count(),
                'notifications' => $notifications,
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }

    public function notification_show($id)
    {
        $user = auth()->user();
        if ($user) {
            $notification = Notification::where('id', $id)->where(function ($q) use ($user) {
                $q->where('notification_to', $user->id);
                $q->orWhere('notification_from', $user->id);
            })->first();
            if ($notification) {
                $notification->update(['is_readed' => 1]);
            }

            return response()->json([
                'success' => 1,
                'message' => 'updated',

            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }

    /*------------------Token_Device --------------------------------*/
    public function tokenDevice(Request $request)
    {
        $rules = [
            'Token_Device' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        } else {
            $user = auth()->user();
            if ($user) {
                $user->Device_Token = $request->Token_Device;

                if ($user->save()) {

                    return response()->json([
                        'success' => 1,
                        'message' => 'تم حفظ الجهاز',

                    ], 200);

                } else {
                    return response()->json([
                        'success' => 0,
                        'message' => 'المحاولة مرة أخرى',
                    ], 503);
                }

            } else {
                return response()->json([
                    'success' => 0,
                    'message' => 'Invalid Authentication',
                ], 503);
            }
        }

    }

    /*------------------Token_Device---------------------------------*/

}
