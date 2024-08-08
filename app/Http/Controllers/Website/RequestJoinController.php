<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Request_join_service;
use App\Models\RequestJoin;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Validators\ReCaptcha;


class RequestJoinController extends Controller
{
    public function requestJoin()
    {
        $services = Services::get();

        return view('website.request-join', compact('services'));
    }

    public function requestJoinSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required|max:100',
            'store' => 'required|max:100',
            'services' => 'required',
            'g-recaptcha-response' => 'required|recaptcha'

        ]);
        $requestJoin = RequestJoin::create($request->all());
        if ($request->services) {
            $services = $request->services;
            foreach ($services as $service) {
                $Req_ser = new Request_join_service();
                $Req_ser->request_join_id = $requestJoin->id;
                $Req_ser->service_id = $service;
                $Req_ser->save();
            }
        }
        if ($requestJoin) {
            $notification = [
                'message' => __('website.send_success'),
                'alert-type' => 'success',
            ];
        }

        return back()->with($notification);
    }
}
