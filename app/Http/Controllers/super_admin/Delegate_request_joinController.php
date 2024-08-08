<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Request_join_user;
use Illuminate\Http\Request;

class Delegate_request_joinController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $Request_joins = Request_join_user::where('type', 'delegate')->orderBy('id', 'desc')->paginate(25);

        return view('super_admin.Request_joins_delegate.index', compact('Request_joins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delegate = Request_join_user::find($id);
        $delegate->is_read = 1;
        $delegate->save();

        return view('super_admin.Request_joins_delegate.show', compact('delegate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Request_join_user::findOrFail($id);
        $user->delete();

        $notification = [
            'message' => '<h3>تم التحويل بنجاح</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
