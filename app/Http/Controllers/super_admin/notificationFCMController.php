<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Fcm_notification;
use App\Models\Fcm_notification_delegate;
use App\Models\Post;
use App\Models\User;
use App\Models\WebSetting;
use App\Traits\PushNotificationsTrait;
use Illuminate\Http\Request;

class notificationFCMController extends Controller
{
    use PushNotificationsTrait;

    public function __construct()
    {
        // $this->middleware('permission:show_post', ['only'=>'index', 'show']);
        // $this->middleware('permission:add_post', ['only'=>'create', 'store']);
        // $this->middleware('permission:edit_post', ['only'=>'edit', 'update']);
        // $this->middleware('permission:delete_post', ['only'=>'destroy']);
    }

    public function index()
    {
        $Notificationfcm = Fcm_notification::orderBy('id', 'desc')->paginate(50);

        return view('super_admin.notificationFCM.index', compact('Notificationfcm'));
    }

    public function create()
    {

        $delegates = User::where('user_type', 'delegate')->where('Device_Token','!=',null)->get();

        return view('super_admin.notificationFCM.add', compact('delegates'));
    }

    public function store(Request $request)
    {
        $WebSetting = WebSetting::find(1);

        $request->validate([
            'title' => 'required',
            'message' => 'required',
        ]);
        $title = $request->title;
        $message = $request->message;
        $image = asset($WebSetting->logo);


        if (isset($request->delegate)) {
            if($request->delegate[0]=='all')
            {
                $delegates = User::where('user_type', 'delegate')->where('Device_Token','!=',null)->pluck('id')->toArray();

            }else{
                $delegates = $request->delegate;

            }
        
        } else {
            $delegates = User::where('user_type', 'delegate')->where('Device_Token','!=',null)->pluck('id')->toArray();
        }
        $notification = new Fcm_notification();
        $notification->notification_from = Auth()->user()->id;
        $notification->title = $title;
        $notification->message = $message;
        $notification->save();

        foreach ($delegates as $delegate) {
            $delegate = User::find($delegate);

            $fcmnotifuction_delegates = new Fcm_notification_delegate();
            $fcmnotifuction_delegates->fcm_notification_id = $notification->id;
            $fcmnotifuction_delegates->to = $delegate->id;
            $fcmnotifuction_delegates->save();

            $token = $delegate->Device_Token;
            if ($token != null) {
                // $this->sendNotificationWithImage($token, $title, $message, $image);
                $this->sendNotification($token, $title, $message);

                
            }

        }

        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('notificationFCM.index')->with($notification);
    }

    public function show($id)
    {

        $Notificationfcm = Fcm_notification::find($id);
        $Fcmnotifuction_delegate = Fcm_notification_delegate::where('fcm_notification_id', $id)->get();

        return view('super_admin.notificationFCM.show', compact('Notificationfcm', 'Fcmnotifuction_delegate'));

    }

    public function destroy($id)
    {
        $post = Fcm_notification::findOrFail($id);
        Fcm_notification_delegate::where('fcm_notification_id', $id)->delete();

        $post->delete();

        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
