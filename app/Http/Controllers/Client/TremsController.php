<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Company_setting;
use App\Models\Zone;
use App\Models\Zone_account;

class TremsController extends Controller
{
    public function index()
    {
        $company_settings = Company_setting::where('company_id', Auth()->user()->company_id)->first();
        $zones = Zone::where('company_id', Auth()->user()->company_id)->where('type', 'city')->get();
        $Zone_accounts = Zone_account::where('user_id', Auth()->user()->id)->get();

        return view('client.terms.show', compact('zones', 'Zone_accounts'));
    }

    public function agree()
    {
        $user = Auth()->user();
        $data = ['read_terms' => 1];
        $user->update($data);
        $notification = [
            'message' => '<h3>Thank you for Agree </h3>',
            'alert-type' => 'info',
        ];

        return redirect()->route('client.dashboard')->with($notification);
    }
}
