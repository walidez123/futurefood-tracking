<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Notifications;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Order;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($id)
    {

        $user = auth()->user();
        $order = Order::findOrFail($id);
        if ($order) {
            $comments = $order->comments()->get();

            return view('admin.delegates.comments', compact('order', 'comments'));
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $order = Order::findOrFail($request->order_id);
        $user->comments()->create($request->all());
        Notifications::addNotification('تعليق جديد', ' تم اضافة تعليق جديد علي طلب الشحن رقم  : '.$order->order_id, 'comment', $order->delegate_id, 'delegate');

        $notification = [
            'message' => '<h3>Save Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment) {
            $comment->delete();
        }
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
