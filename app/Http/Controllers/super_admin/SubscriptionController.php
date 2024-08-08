<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:show_SubscriptionUs', ['only' => 'index', 'show']);
        // $this->middleware('permission:delete_SubscriptionUs', ['only' => 'destroy']);
    }

    public function index()
    {
        $Subscriptions = Subscription::orderBy('id', 'desc')->paginate(25);

        return view('super_admin.website.Subscriptions.index', compact('Subscriptions'));
    }

    public function show(Subscription $Subscription)
    {
        $is_readed = [
            'is_readed' => 1,
        ];
        $Subscription->update($is_readed);

        return view('super_admin.website.Subscriptions.show', compact('Subscription'));
    }

    public function destroy($id)
    {
        $Subscription = Subscription::findOrFail($id);
        if ($Subscription) {
            $Subscription->delete();
        }
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('subscription.index')->with($notification);
    }
}
