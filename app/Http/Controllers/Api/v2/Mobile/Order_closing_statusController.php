<?php

namespace App\Http\Controllers\Api\v2\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\BalanceResource;
use App\Mail\ContactEmail;
use App\Models\ClientTransactions;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Order_closing_statusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

       
        if ($user) {
            $status=$user->company_setting->status_shop;
            return response()->json([
                'success' => 1,
                'status_id' =>$status,
            ], 200);
        }

        return response()->json([
            'success' => 0,
            'message' => __('api_massage.try again'),
        ], 500);
    }


    public function restaurant(Request $request)
    {
        $user = auth()->user();

       
        if ($user) {
            $status=$user->company_setting->status_res;
            return response()->json([
                'success' => 1,
                'status_id' =>$status,
            ], 200);
        }

        return response()->json([
            'success' => 0,
            'message' => __('api_massage.try again'),
        ], 500);
    }

    public function fulfilment(Request $request)
    {
        $user = auth()->user();

       
        if ($user) {
            $status=$user->company_setting->stutus_fulfilment;
            return response()->json([
                'success' => 1,
                'status_id' =>$status,
            ], 200);
        }

        return response()->json([
            'success' => 0,
            'message' => __('api_massage.try again'),
        ], 500);
    }

   
}
