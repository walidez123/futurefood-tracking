<?php

namespace App\Http\Controllers\Api\Service_provider;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('login', 'forgetPassword', 'resetPassword');
        // Unique Token
        $this->apiToken = uniqid(base64_encode(str_random(60)));
    }

    public function login(Request $request)
    {
        // Validations
        $rules = [
            'phone' => 'required',
            'password' => 'required|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        } else {
            $credentials = $request->only('phone', 'password');
            if (Auth::attempt($credentials)) {
                $apiToken = ['api_token' => $this->apiToken];

                $user = User::where('phone', $request->phone)->first();
                if ($user->user_type == 'service_provider') {
                    User::where('phone', $request->phone)->update($apiToken);


                    return response()->json([
                        'success' => 1,
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => $user->phone,
                            'api_token' => $user->api_token,
                        ],
                    ]);
                } else {
                    return response()->json([
                        'success' => 0,
                        'message' => 'رقم الجوال او الرقم السري غير صحيح',
                    ]);
                }

            } else {
                return response()->json([
                    'message' => 'رقم الجوال او الرقم السري غير صحيح',
                ]);
            }

        }
    }

    public function logout(Request $request)
    {
        $apiToken = ['api_token' => null];
        $logout = User::where('id', $request->user()->id)->update($apiToken);

        return response()->json([
            'message' => 'تم تسجيل الخروج',
        ]);

    }

    public function forgetPassword(Request $request)
    {
        $rules = [
            'phone' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'success' => 0,
                'message' => $validator->messages(),
            ]);
        }
        $phone = $request->phone;
        $check = User::where('phone', $phone)->first();
        if (! $check) {

            return response()->json([
                'message' => 'رقم الجوال غير موجود',
            ], 404);
        }
        $code = rand(1000, 9999);
        $createAt = time();
        $expiredDate = date('Y-m-d H:i:s', strtotime('+1 day', $createAt));
        // return $expiredDate;
        $updatedData = [
            'reset_code' => $code,
            'code_expired_at' => $expiredDate,
        ];
        // return $check;
        $update = User::where('phone', $phone)->update($updatedData);
        if ($update) {
            $message = 'كود تاكيد خاص بيك '.$code;
            SendSMSCode($phone, $message);

            return response()->json([
                'success' => 1,
                'message' => 'تم أرسال رقم التأكيد فى رسالة نصية الى هاتفك',
                'code' => $code,
            ], 200);

        }

        return response()->json([
            'success' => 0,
            'message' => 'حاول مرة أخرى',
        ], 500);

    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'code' => 'required|numeric|min:4',
            'password' => 'required|min:6',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'success' => 0,
                'message' => $validator->messages(),
            ]);
        }
        $code = $request->code;
        $user = User::where('reset_code', $code)->first();
        if (! $user) {
            return response()->json([
                'success' => 0,
                'message' => 'This code is not valid',
            ], 500);
        }
        $now = now();
        // return $now;
        if ($user->code_expired_at < $now) {
            return response()->json([
                'success' => 0,
                'message' => 'This code is expired',
            ], 500);
        }

        $data = [
            'password' => bcrypt($request->password),
            'reset_code' => null,
            'code_expired_at' => null,
        ];
        $update = User::where('email', $user->email)->update($data);

        if ($update) {
            return response()->json([
                'success' => 1,
                'message' => 'password changed successfully',
            ], 200);
        }

        return response()->json([
            'success' => 0,
            'message' => 'somthing wrong please try againe later',
        ], 500);
    }

    public function analytics(Request $request)
    {
        $user = Auth::user();

        $ordersToday = $user->orders()->PickupToday()->count();
        $balance = DB::table('client_transactions')->select([DB::raw('SUM(debtor - creditor) as total')])
            ->where('user_id', $user->id)
            ->where('deleted_at', null)
            ->first();
        $balance = $balance->total;
        $allMyOrders = $user->orders()->count();

        return response()->json([
            'success' => 1,
            'Statistics' => [
                'OrdersShipToday' => $ordersToday,
                'AllMyOrders' => $allMyOrders,
                'BalanceAccount' => $balance,
            ],
        ]);
    }
}