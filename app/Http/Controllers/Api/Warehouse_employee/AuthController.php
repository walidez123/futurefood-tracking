<?php

namespace App\Http\Controllers\Api\Warehouse_employee;

use App\Events\SendLocation;
use App\Http\Controllers\Controller;
use App\Models\Request_join_user;
use App\Models\Delegate_work;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $apiToken;

    public function __construct()
    {
        $this->middleware('auth:api')->except('login', 'request_join', 'forgetPassword', 'resetPassword');
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
                if ($user->company->company_active == 1 && $user->is_active == 1) {
                    if ($user->user_type == 'admin') {

                        User::where('phone', $request->phone)->update($apiToken);
                        if ($user->avatar == 'avatar/avatar.png' || $user->avatar == null) {
                            $webSetting = WebSetting::findOrFail(1);

                            $image = asset('storage/' . $webSetting->logo);
                        } else {
                            $image = asset('storage/' . $user->avatar);

                        }

                        //this to work on the old version of api

                       
                        return response()->json([
                            'success' => 1,
                            'user' => [
                                'id' => $user->id,
                                'code' => $user->code,
                                'company_name' => $user->company->name,
                                'name' => $user->name,
                                'email' => $user->email != null ? $user->email : '',
                                'phone' => $user->phone,
                                'avatar' => $image,
                                'api_token' => $this->apiToken,
                            ],
                        ]);
                    } else {
                        return response()->json([
                            'success' => 0,
                            'message' => __('api_massage.faild_type'),
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 0,
                        'message' => __('api_massage.Inactive delegate'),
                    ]);
                }

            } else {
                return response()->json([
                    'success' => 0,

                    'message' => __('api_massage.faild_auth'),
                ]);
            }

        }
    }

    public function logout(Request $request)
    {
        $apiToken = ['api_token' => null];
        $logout = User::where('id', $request->user()->id)->update($apiToken);

        return response()->json([
            'success' => 1,
            'message' => __('api_massage.logout'),

        ]);

    }

    public function profile()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 500);
        }

        if ($user->avatar == 'avatar/avatar.png' || $user->avatar == null) {
            $webSetting = WebSetting::findOrFail(1);

            $image = asset('storage/' . $webSetting->logo);
        } else {
            $image = asset('storage/' . $user->avatar);

        }

        return response()->json([
            'success' => 1,
            'user' => [
                'id' => $user->id,
                'code' => $user->code,
                'company_name' => $user->company->name,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'avatar' => $image,

            ],
        ]);

    }

    public function forgetPassword(Request $request)
    {

        $rules = [
            'phone' => 'required|',
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
        if (!$check) {
            return response()->json([
                'success' => 0,

                'message' => __('api_massage.Faild phone number'),
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
            $message = $code . __('api_massage.Your confirmation code');

            SendSMSCode($phone, $message);

            //   Mail::to($email)->send(new ResetEmail($code));
            return response()->json([
                'success' => 1,
                'message' => __('api_massage.A confirmation code has been sent to your phone'),
                'code' => __('api_massage.A confirmation code has been sent to your phone'),
            ], 200);

        }

        return response()->json([
            'success' => 0,
            'message' => __('api_massage.try again'),

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
        if (!$user) {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Faild code'),
            ], 500);
        }
        $now = now();
        // return $now;
        if ($user->code_expired_at < $now) {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Expired code'),
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
                'message' => __('api_massage.The password has been changed successfully.'),

            ], 200);
        }

        return response()->json([
            'success' => 0,
            'message' => __('api_massage.try again'),
        ], 500);
    }

    public function location(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 500);
        }

        $rules = [
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        }
        $lat = $request->lat;
        $long = $request->long;
        $id = $user->id;
        $name = $user->name;

        $avater = asset('storage/' . $user->avatar);
        $location = [
            'lat' => $lat,
            'long' => $long,
            'id' => $id,
            'name' => $name,
            'avatar' => $avater,
        ];

        event(new SendLocation($location));

        return response()->json(['success' => 1, 'data' => $location]);
    }

    public function analytics(Request $request)
    {
        $user = Auth::user();
        // $user=User::find($user);
          //this to work on the old version of api
          $works = Delegate_work::where('delegate_id', $user->id)->pluck('work')->toArray();

          if (in_array(1, $works) && in_array(2, $works)) {
              $work = 3;

          } elseif (in_array(1, $works)) {
              $work = 1;

          } elseif (in_array(2, $works)) {
              $work = 2;

          }
          // end
        $company = $user->company_setting;
        if ($work == 1) {
            $status_id = $company->status_pickup;

        } elseif($work==2) {
            $status_id = $company->status_pickup_res;

        }elseif($work==3){
            $status_id = $company->status_pickup;

        }

        $ordersToday = $user->ordersDelegate()->PickupToday()->count();
        $ordersPickup = $user->ordersDelegate()->where('status_id', $status_id)->count();

        $balance = DB::table('client_transactions')->select([DB::raw('SUM(debtor - creditor) as total')])
            ->where('user_id', $user->id)
            ->where('deleted_at', null)
            ->first();
        $balance = $balance->total;
        $allMyOrders = $user->ordersDelegate()->count();

        return response()->json([
            'success' => 1,
            'Statistics' => [
                'OrdersShipToday' => $ordersToday,
                'AllMyOrders' => $allMyOrders,
                'ordersPickup' => $ordersPickup,

                'BalanceAccount' => $balance,
            ],
        ]);
    }

    public function request_join(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required|unique:request_join_users,phone',
            'nationality' => 'required',
            'city_id' => 'required',
            'Residency_number' => 'required|min:6',
            'email' => 'email|unique:request_join_users',
            'avatar' => 'mimes:jpeg,png,jpg',
            'vehicle_photo' => 'mimes:jpeg,png,jpg',
            'residence_photo' => 'mimes:jpeg,png,jpg',
            'license_photo' => 'mimes:jpeg,png,jpg',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        } else {
            $delegateData = $request->all();
            $delegateData['type'] = 'delegate';

            if ($request->hasFile('avatar')) {
                $avatar = 'avatar/' . $delegateData['type'] . '/' . $request->file('avatar')->hashName();
                $uploaded = $request->file('avatar')->storeAs('public', $avatar);
                if ($uploaded) {
                    $delegateData['avatar'] = $avatar;
                }

            }
            if ($request->hasFile('vehicle_photo')) {
                $vehicle_photo = 'avatar/' . $delegateData['type'] . '/' . $request->file('vehicle_photo')->hashName();
                $uploaded = $request->file('vehicle_photo')->storeAs('public', $vehicle_photo);
                if ($uploaded) {
                    $delegateData['vehicle_photo'] = $vehicle_photo;
                }

            }if ($request->hasFile('license_photo')) {
                $license_photo = 'avatar/' . $delegateData['type'] . '/' . $request->file('license_photo')->hashName();
                $uploaded = $request->file('license_photo')->storeAs('public', $license_photo);
                if ($uploaded) {
                    $delegateData['license_photo'] = $license_photo;
                }

            }if ($request->hasFile('residence_photo')) {
                $residence_photo = 'avatar/' . $delegateData['type'] . '/' . $request->file('residence_photo')->hashName();
                $uploaded = $request->file('residence_photo')->storeAs('public', $residence_photo);
                if ($uploaded) {
                    $delegateData['residence_photo'] = $residence_photo;
                }

            }
            $delegate = Request_join_user::create($delegateData);
            if ($delegate) {
                return response()->json([
                    'success' => 1,
                    'message' => __('api_massage.Your application to join has been successfully registered.'),

                ], 200);
            }

            return response()->json([
                'success' => 0,
                'message' => __('api_massage.try again'),
            ], 500);
        }

    }
}
