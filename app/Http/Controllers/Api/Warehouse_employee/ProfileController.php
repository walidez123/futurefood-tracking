<?php

namespace App\Http\Controllers\Api\Warehouse_employee;

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
use Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function update(Request $request)
    {
        $id = $request->user()->id;
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|unique:users,email,'.$id,
            'phone' => 'required|unique:users,phone,'.$id,
            'city_id ' => 'numeric',
            'region_id' => 'numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        }
        //   return $request->all();
        $update = User::where('id', $id)->where('user_type', 'admin')->update($request->all());
        //
        if ($request->hasFile('avatar')) {
            $avatar = 'avatar/admin/'.$request->file('avatar')->hashName();
            $uploaded = $request->file('avatar')->storeAs('public', $avatar);
            $user = User::where('id', $id)->where('user_type', 'admin')->first();
            $user->avatar = $avatar;
            $user->save();

        }

        //
        if ($update) {
            return response()->json([
                'success' => 1,
                'message' => __('api_massage.Saved successfully'),
            ], 200);
        }

        return response()->json([
            'success' => 0,
            'message' => __('api_massage.try again'),
        ], 500);
    }

  

    public function changePassword(Request $request)
    {

        $user = Auth::user();

        if ($user->user_type == 'admin') {
            $rules = [
                'old_password' => 'required',
                'new_password' => 'required|min:6',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // Validation failed
                return response()->json([
                    'message' => $validator->messages(),
                ]);
            }

            if (! Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'success' => 0,
                    'message' => __('api_massage.Invalid Old Password'),

                ], 404);
            }
            $user->fill([
                'password' => Hash::make($request->new_password),
            ])->save();

            return response()->json([
                'success' => 1,
                'message' => __('api_massage.password changed successfully'),
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

  
}
