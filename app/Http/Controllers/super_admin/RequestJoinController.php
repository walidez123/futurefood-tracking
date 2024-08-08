<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Request_join_service;
use App\Models\RequestJoin;

class RequestJoinController extends Controller
{
    public function __construct()
    {
       
    }

    public function index()
    {
        $requestJoin = RequestJoin::orderBy('id', 'DESC')->get();

        return view('super_admin.requests.index', compact('requestJoin'));
    }

    public function show(RequestJoin $requestJoin)
    {
        $is_readed = [
            'is_readed' => 1,
        ];
        $requestJoin->update($is_readed);

        $Request_join_service = Request_join_service::where('request_join_id', $requestJoin->id)->get();

        return view('super_admin.requests.show', compact('requestJoin', 'Request_join_service'));
    }

    public function destroy($id)
    {
        $requestJoin = RequestJoin::findOrFail($id);
        if ($requestJoin) {
            Request_join_service::where('request_join_id', $requestJoin->id)->delete();
            $requestJoin->delete();
        }
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('request-joins.index')->with($notification);
    }
}
