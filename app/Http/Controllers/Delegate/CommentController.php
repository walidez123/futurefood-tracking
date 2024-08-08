<?php

namespace App\Http\Controllers\Delegate;

use App\Helpers\Notifications;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($id)
    {

        $user = auth()->user();
        $order = Order::where('id', $id)->where('delegate_id', $user->id)->first();
        if ($order) {
            $comments = $order->comments()->get();

            return view('delegate.orders.comments', compact('order', 'comments'));
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $user->comments()->create($request->all());
        $order = Order::findOrFail($request->order_id);
        Notifications::addNotification('تعليق جديد', ' تم اضافة تعليق جديد علي طلب الشحن رقم  : '.$order->order_id, 'comment', null, 'admin', $order->id);
        $notification = [
            'message' => '<h3>Save Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
