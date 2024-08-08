<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //order_notification
    public function orderNotification($id)
    {
        $order = Order::where('id', $id)->first();
        $notifications = Notification::where('order_id', $id)
            ->where('title', 'NOT LIKE', 'طلب شحن جديد')->orderBy('order_id', 'DESC')->paginate(15);

        return view('notifications.order', compact('notifications', 'order'));
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        if ($request->exists('unread') || ! $request->exists('readable')) {
            if ($user->user_type == 'admin') {
                $notifications = Notification::where('title', 'NOT LIKE', 'طلب شحن جديد')->where(function ($q) use ($user) {
                    $q->where('notification_to_type', 'admin');
                    $q->orWhere('notification_from', $user->id);
                })->Unread()->orderBy('order_id', 'DESC')->paginate(15);
            } else {
                $notifications = Notification::where(function ($q) use ($user) {
                    $q->where('notification_to', $user->id);
                    $q->orWhere('notification_from', $user->id);
                })->Unread()->orderBy('order_id', 'DESC')->paginate(15);
            }
        } elseif ($request->exists('readable')) {
            if ($user->user_type == 'admin') {
                $notifications = Notification::where('title', 'NOT LIKE', 'طلب شحن جديد')->where(function ($q) use ($user) {
                    $q->where('notification_to_type', 'admin');
                    $q->orWhere('notification_from', $user->id);
                })->read()->orderBy('order_id', 'DESC')->paginate(15);
            } else {
                $notifications = Notification::where(function ($q) use ($user) {
                    $q->where('notification_to', $user->id);
                    $q->orWhere('notification_from', $user->id);
                })->read()->orderBy('order_id', 'DESC')->paginate(15);
            }
        }

        return view('notifications.index', compact('notifications'));
    }

    public function store(Request $request)
    {
        Notification::create($request->all());
        $notification = [
            'message' => '<h3>Send Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    public function show($id)
    {
        $user = auth()->user();
        if ($user->user_type == 'admin') {
            $notification = Notification::where('id', $id)->where(function ($q) use ($user) {
                $q->where('notification_to_type', 'admin');
                $q->orWhere('notification_from', $user->id);
            })->first();
            if ($notification) {
                $notification->update(['is_readed' => 1]);
            }

            return view('notifications.show', compact('notification'));
        } else {
            $notification = Notification::where('id', $id)->where(function ($q) use ($user) {
                $q->where('notification_to', $user->id);
                $q->orWhere('notification_from', $user->id);
            })->first();
            if ($notification) {
                $notification->update(['is_readed' => 1]);
            }

            return view('notifications.show', compact('notification'));
        }
        abort(404);
    }

    public function unread($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_readed' => 0]);

        return redirect()->route('notifications.index');
    }

    /*------------------Token Device API-------------------------------*/
    public function tokenDevice(Request $request)
    {
        $rules = [
            'Token_Device' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
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
    /*------------------Token Device API---------------------------------*/
}
