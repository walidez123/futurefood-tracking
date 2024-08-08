<?php

namespace App\Http\Controllers\Api\Warehouse_employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Resources\GoodsResource;
use App\Http\Resources\ClientPackagesGoodResource;
use App\Models\Client_packages_good;
use App\Models\Good;
use App\Models\packages_goods;
use App\Models\PaletteSubscription;
use App\Models\User;
use App\Models\Warehouse_content;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User_package;

class warehouse_clientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function warehouse()
    {
        $user = Auth()->user();

        if ($user->user_type == 'admin') {

            $clients = ClientResource::collection(User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->where('work', 3)->paginate(15));

            return response()->json($clients);

        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function fuliflment()
    {
        $user = Auth()->user();
        if ($user->user_type == 'admin') {
            $clients = ClientResource::collection(User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->where('work', 4)->paginate(15));
            return response()->json($clients);
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }

    }

    public function store(Request $request)
    {
        $rules = [
            'client_id' => 'required',
            'warhouse_id' => 'required',
            'SKUS.*' => [
                'required',
                Rule::exists('goods', 'id')->where(function ($query) {
                    return $query->where('company_id', Auth()->user()->company_id);
                }),
            ],
            'package_id.*' => [
                'required',
                Rule::exists('warehouse_contents', 'id')->where(function ($query) {
                    return $query->where('type', 'package');
                }),
            ],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ]);
        }
        $client = User::where('id', $request->client_id)->first();

        $packages = [];
        foreach ($request->package_id as $i => $package_title) {
            if ($package_title && in_array($package_title, $packages) == false) {
                $packages[$i] = $package_title;
            }
        }
        $total_packages = count($packages);
        // chick area free for user
        $free_area = $this->checkFreeArea($total_packages, $request->client_id);
        if ($request->work == 1) {
            if ($free_area < 0) {

                // 
                $message = __('admin_message.There is not enough space for these products');

                return response()->json([
                    'success' => 0,
                    'message' =>$message,
                ]);
            }
        }
        //
        $goods = [];
        foreach ($request->SKUS as $i => $SKUS) {
            if ($SKUS && in_array($SKUS, $goods) == false) {
                $goods[$i] = $SKUS;
            }
        }
        $total_goods = count($goods);
        $packages_goods = new packages_goods();
        $packages_goods->company_id = Auth()->user()->company_id;
        $packages_goods->work = $request->work;
        $packages_goods->client_id = $request->client_id;
        $packages_goods->warehouse_id = $request->warhouse_id;
        $packages_goods->total_goods = $total_goods;
        $packages_goods->total_packages = $total_packages;
        $packages_goods->save();
        // save single tabel
        $expire_date_counter = 0;
        foreach ($request->SKUS as $i => $sku) {
            $good = Good::where('id', $sku)->where('company_id', Auth()->user()->company_id)->first();

            $package = Warehouse_content::where('id', $request->package_id[$i])->first();
            $package->is_busy = 1;
            $package->save();
            $Client_packages_good = new Client_packages_good();
            $Client_packages_good->company_id = Auth()->user()->company_id;
            $Client_packages_good->client_id = $packages_goods->client_id;
            $Client_packages_good->warehouse_id = $packages_goods->warehouse_id;
            $Client_packages_good->packages_good_id = $packages_goods->id;
            $Client_packages_good->work = $request->work;
            $Client_packages_good->good_id = $good->id;
            $Client_packages_good->number = $request->number[$i];
            if ($good->has_expire_date == 0) {
                $Client_packages_good->expiration_date = null; // or any default value you see fit

            } else {
                $Client_packages_good->expiration_date = $request->expiration_date[$expire_date_counter]; // or any default value you see fit
                $expire_date_counter = $expire_date_counter + 1;

            }
            $Client_packages_good->packages_id = $package->id;
            $Client_packages_good->save();

            $cost =  $client->UserCost->store_palette;
            $tax = $cost * $client->tax / 100;
            $total = $cost + $tax;

            if ($Client_packages_good->client->UserCost->pallet_subscription_type == 'daily') {
                $subscription = PaletteSubscription::create([
                    'client_packages_goods_id' => $Client_packages_good->id,
                    'transaction_type_id' => 18,
                    'user_id' => $client->id,
                    'cost' => $total,
                    'description' => "تكلفه تخزين الرف" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax,
                    'start_date' => Carbon::now(),
                    'type' => 'daily',
                ]);
            } else {
                $subscription = PaletteSubscription::create([
                    'client_packages_goods_id' => $Client_packages_good->id,
                    'transaction_type_id' => 19,
                    'user_id' => $client->id,
                    'cost' => $total,
                    'description' => "تكلفه تخزين الرف" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax,
                  
                    'start_date' => Carbon::now(),
                    'type' => 'monthly',
                ]);
            }

        }

            return response()->json([
                'success' => 1,
                'message' => __('api_massage.Saved successfully'),
            ], 200);
    
    }


    private function checkFreeArea($total_packages, $client_id)
    {
        $user = User::findOrFail($client_id);
        $packages = User_package::where('user_id', $user->id)->get();
        $total_area = $packages->sum('area');
        //
        $packages_goods = packages_goods::where('client_id', $client_id)->get();
        if ($packages_goods !== null) {
            $packages = $packages_goods->sum('total_packages') + $total_packages;
            $packages_area = $packages * 2;
            $free_area = $total_area - $packages_area;
        } else {

            $packages = $total_packages;
            $packages_area = $packages * 2;
            $free_area = $total_area - $packages_area;
        }

        return $free_area;

    }


    public function fuliflment_goods(request $request){

        if (Auth()->user()->user_type == 'admin') {
            $user=User::where('id',$request->client_id)->where('work',4)->first();

            if($user)
            {
                $goods = GoodsResource::collection( Good::where('company_id', Auth()->user()->company_id)->where('client_id',$user->id)->get());

                return response()->json($goods);

            }else{
                return response()->json([
                    'success' => 0,
                    'message' => __('api_massage.client not found'),
                ], 503);
            }

           

        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }   

    }

    public function list_fuliflment()
    {
        $user = Auth()->user();

        if ($user->user_type == 'admin') {
        $packages_goods=Client_packages_good::where('work',2)->where('company_id',Auth()->user()->company_id);

        $data = ClientPackagesGoodResource::collection($packages_goods->orderBy('id','desc')->paginate(15));

        return response()->json($data);
    } else {
        return response()->json([
            'success' => 0,
            'message' => __('api_massage.Invalid Authentication'),
        ], 503);
    } 

    }

    public function list_warehouse()
    {
        $user = Auth()->user();

        if ($user->user_type == 'admin') {
        $packages_goods=Client_packages_good::where('work',1)->where('company_id',Auth()->user()->company_id);

        $data = ClientPackagesGoodResource::collection($packages_goods->orderBy('id','desc')->paginate(15));

        return response()->json($data);
    } else {
        return response()->json([
            'success' => 0,
            'message' => __('api_massage.Invalid Authentication'),
        ], 503);
    } 

    }


    public function free_area(request $request){
        if (Auth()->user()->user_type == 'admin') {
            $user=User::where('id',$request->client_id)->where('work',3)->first();

            if($user)
            {
                $packages = User_package::where('user_id', $user->id)->get();
                $total_area = $packages->sum('area');
                //
                $packages_goods = packages_goods::where('client_id', $user->id)->get();
                if ($packages_goods !== null) {
                    $packages = $packages_goods->sum('total_packages');
                    $packages_area = $packages * 2;
                    $free_area = $total_area - $packages_area;
                } else {
                    $free_area = $total_area;
                }
        
                //

                return response()->json([
                    'success' => 1,
                    'user' => [
                        'free_area' => $free_area,
                        'total_area' => $total_area,
                        'Busy_area' => $packages_area
                       
                    ],
                ]);
        

            }else{
                return response()->json([
                    'success' => 0,
                    'message' => __('api_massage.client not found'),
                ], 503);
            }

           

        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        } 

    }


}
