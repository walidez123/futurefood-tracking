<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client_packages_good;
use App\Models\Company_work;
use App\Models\Good;
use App\Models\packages_goods;
use App\Models\Pickup_order;
use App\Models\Pickup_orders_good;
use App\Models\User;
use App\Models\User_package;
use App\Models\Warehouse_branche;
use App\Models\Warehouse_content;
use App\Models\PaletteSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Packages_history;

class Packages_goodsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_packaging_goods', ['only' => 'index', 'show']);
        $this->middleware('permission:add_packaging_goods', ['only' => 'create', 'store']);
        $this->middleware('permission:delete_packaging_goods', ['only' => 'destroy']);

    }

    public function index(request $request)
    {
        $type = $request->type;
        $client_packages_goods = Client_packages_good::where('company_id', Auth()->user()->company_id)->where('work', $request->type)->orderBy('id', 'desc')->paginate(25);


        return view('admin.packages_goods.index', compact('client_packages_goods', 'type'));
    }

    public function scan($id)
    {
        $order = Pickup_order::where('id', $id)->first();
        $products = Pickup_orders_good::where('order_id', $id)->get();
        if ($order->work_type == 3) {
            $type = 1;
        } else {
            $type = 2;

        }
        $client = User::where('id', $order->user_id)->first();
        if ($client->work == 3) {
            $packages = Warehouse_content::where('warehouse_id', $order->warehouse_id)->where('work','1')->where('type', 'package')->orderBy('id', 'desc')->get();

            $goods = Good::where('company_id', Auth()->user()->company_id)->where('client_id',  $client->id)->get();

        } elseif ($client->work == 4) {
            $packages = Warehouse_content::where('warehouse_id', $order->warehouse_id)->where('work','2')->where('type', 'package')->orderBy('id', 'desc')->get();

            $goods = Good::where('company_id', Auth()->user()->company_id)->where('client_id', $client->id)->get();

        }

        return view('admin.packages_goods.create_pickup', compact('products', 'order', 'type', 'packages', 'goods'));
    }

    public function show($id)
    {
        $packages_good = Client_packages_good::find($id);
        $Packages_historys = Packages_history::where('Client_packages_good', $id)->paginate(25);

        return view('admin.packages_goods.show', compact('packages_good', 'Packages_historys'));

    }

    public function create(request $request)
    {
        $type = $request->type;
        if ($type == 1) {
            $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->where('work', 3)->orderBy('id', 'DESC')->get();

        } elseif ($request->type == 2) {

            $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->where('work', 4)->orderBy('id', 'DESC')->get();

        }
        $warehouse_branchs = Warehouse_branche::whereIn('work', [$type, 3])->where('company_id', Auth()->user()->company_id)->get();

        return view('admin.packages_goods.create', compact('clients', 'warehouse_branchs', 'type'));
    }

    public function store(request $request)
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
            'package_title.*' => [
                'required',
                Rule::exists('warehouse_contents', 'id')->where(function ($query) {
                    return $query->where('type', 'package');
                }),
            ],

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $client = User::where('id', $request->client_id)->first();

        $packages = [];
        foreach ($request->package_title as $i => $package_title) {
            if ($package_title && in_array($package_title, $packages) == false) {
                $packages[$i] = $package_title;
            }
        }
        $total_packages = count($packages);
        // chick area free for user
        $free_area = $this->checkFreeArea($total_packages, $request->client_id);
        if ($client->work == 3) {
            if ($free_area < 0) {
                $message = __('admin_message.There is not enough space for these products');

                return redirect()->back()->with('error', $message);

            }
        }
        //
      
     
        $expire_date_counter=0;
        foreach ($request->SKUS as $i => $sku) {
            $good = Good::where('id', $sku)->where('company_id', Auth()->user()->company_id)->first();
           
            $package = Warehouse_content::where('id', $request->package_title[$i])->first();
            $package->is_busy = 1;
            $package->save();
            $Client_packages_good = new Client_packages_good();
            if($request->order_id!=null)
            {
                $Client_packages_good->order_id=$request->order_id;
            }
            $Client_packages_good->company_id = Auth()->user()->company_id;
            $Client_packages_good->client_id = $request->client_id;
            $Client_packages_good->warehouse_id = $request->warhouse_id;
            $Client_packages_good->work = $request->work;
            $Client_packages_good->good_id = $good->id;
            $Client_packages_good->number = $request->number[$i];
            if($good->has_expire_date==0)
            {
                $Client_packages_good->expiration_date =null; // or any default value you see fit

            }else{ 
                $Client_packages_good->expiration_date = $request->expiration_date[$expire_date_counter]; // or any default value you see fit
                $expire_date_counter=$expire_date_counter+1;

            }
            $Client_packages_good->packages_id = $package->id;
            // 
            $chick=Client_packages_good::where('company_id', Auth()->user()->company_id)->
            where('client_id',$request->client_id)->where('warehouse_id',$request->warhouse_id)->
            where('work',$request->work)->where('good_id',$good->id)->where('expiration_date',$Client_packages_good->expiration_date)
            ->where('packages_id',$package->id)->first();
            if($chick==NULL){
                $Client_packages_good->save();
                $Packages_historiy=new Packages_history();
                $Packages_historiy->Client_packages_good=$Client_packages_good->id;
                $Packages_historiy->number=$request->number[$i];
                if($request->order_id!=null)
                {
                    $Packages_historiy->order_id=$request->order_id;
                }
                $Packages_historiy->type=1;
                $Packages_historiy->user_id=Auth()->user()->id;
                $Packages_historiy->save();

            }
            else{
                $chick->update(['number'=>($request->number[$i]+$chick->number)]);
                $Packages_historiy=new Packages_history();
                $Packages_historiy->Client_packages_good=$chick->id;
                $Packages_historiy->number=$request->number[$i];
                $Packages_historiy->type=1;
                $Packages_historiy->user_id=Auth()->user()->id;
                $Packages_historiy->save();

            }
            
            $cost =  $client->UserCost->store_palette;
            $tax = $cost * $client->tax / 100;
            $total = $cost + $tax;

            if($Client_packages_good->client->UserCost->pallet_subscription_type == 'daily'){
                $subscription = PaletteSubscription::create([
                    'client_packages_goods_id' => $Client_packages_good->id ,
                    'transaction_type_id' => 18,
                    'user_id'=> $client->id,
                    'cost'=> $total,
                    'description' => "تكلفه تخزين الرف" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax,
                    'start_date' => Carbon::now(),
                    'type' => 'daily',
                ]);
            }else{
                $subscription = PaletteSubscription::create([
                    'client_packages_goods_id' => $Client_packages_good->id ,
                    'transaction_type_id' => 19,
                    'user_id'=> $client->id,
                    'cost'=> $total,
                    'description' => "تكلفه تخزين الرف" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax,
                    'start_date' => Carbon::now(),
                    'type' => 'monthly',
                ]);
            }
                
        }

        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('packages_goods.index', ['type' => $request->work])->with($notification);

    }

    public function destroy($id)
    {

        Client_packages_good::findOrFail($id)->delete();

        // $user = packages_goods::findOrFail($id);

        // packages_goods::findOrFail($id)->delete();
        // Client_packages_good::where('client_id', $user->client_id)->where('warehouse_id', $user->warehouse_id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);

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

    // public function productScan(Request $request)
    // {
    //     $code = $request->input('code');

    //     $product = Good::where('SKUS', $code)->first();

    //   if ($product) {
    //       return response()->json(['success' => true]);
    //   } else {
    //       return response()->json(['error' => 'Product not found'], 404);
    //   }
    // }

    // public function packageScan(Request $request)
    // {
    //     $code = $request->input('code');
    //     $warehouse_id = $request->input('client_id');
    //     $warehouse = Warehouse_branche::where('id', $warehouse_id)->first();
    //     $package = Warehouse_content::where('type', 'package')->where('warehouse_id',$warehouse->id)->where('title', $code)->first();

    //   if ($package) {
    //       return response()->json(['success' => true]);
    //   } else {
    //       return response()->json(['error' => 'Product not found'], 404);
    //   }

    // }

    public function search(request $request)
    {

        $user_type = Company_work::where('company_id', Auth()->user()->company_id)->pluck('work')->toArray();
        if (in_array(3, $user_type)) {
            $goods = Good::where('company_id', Auth()->user()->company_id)->get();
            $warehouse_branchs = Warehouse_branche::whereIn('work', [3])->where('company_id', Auth()->user()->company_id)->get();

        }
        if (in_array(4, $user_type)) {
            $goods = Good::where('company_id', Auth()->user()->company_id)->get();
            $warehouse_branchs = Warehouse_branche::whereIn('work', [4])->where('company_id', Auth()->user()->company_id)->get();

        }
        if (in_array(4, $user_type) && in_array(3, $user_type)) {
            $goods = Good::where('company_id', Auth()->user()->company_id)->get();
            $warehouse_branchs = Warehouse_branche::where('company_id', Auth()->user()->company_id)->get();

        }

        if ($request->exists('type')) {
            $from = $request->get('from');
            $to = $request->get('to');
            $warehouse_branch = $request->get('warhouse_id');
            $single_good = $request->get('goods');
            $packages_goods=Client_packages_good::where('company_id',Auth()->user()->company_id);
            if ($from != null && $to != null) {
                if ($request->type == 'ship') {

                    $packages_goods = $packages_goods->whereDate('updated_at', '>=', $from)
                        ->whereDate('updated_at', '<=', $to);

                } else {
                    $packages_goods = $packages_goods->packages_goods::whereDate('updated_at', '>=', $from)
                        ->whereDate('updated_at', '<=', $to);
                }
            }

            if ($warehouse_branch != null) {
                $packages_goods->where('warehouse_id', $warehouse_branch);
            }

            if ($single_good != null) {

                $packages_goods = $packages_goods->where('good_id',$single_good);
               
            }
            $packages_Goods = $packages_goods->get();

            $totalGoodsCount = $packages_Goods->sum('number');
            $packages_goods = $packages_goods->orderBy('id','DESC')->paginate(25);



            return view('admin.packages_goods.search_product', compact('totalGoodsCount', 'goods', 'packages_goods', 'warehouse_branchs', 'from', 'to', 'single_good', 'warehouse_branch'));

        } else {

            return view('admin.packages_goods.search_product', compact('goods', 'warehouse_branchs'));
        }
    }

    public function clientSearch(request $request)
    {

        $user_type = Company_work::where('company_id', Auth()->user()->company_id)->pluck('work')->toArray();
        if (in_array(3, $user_type)) {
            $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->where('work', 3)->orderBy('id', 'DESC')->get();
            $warehouse_branchs = Warehouse_branche::whereIn('work', [3])->where('company_id', Auth()->user()->company_id)->get();

        }
        if (in_array(4, $user_type)) {
            $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->where('work', 4)->orderBy('id', 'DESC')->get();
            $warehouse_branchs = Warehouse_branche::whereIn('work', [4])->where('company_id', Auth()->user()->company_id)->get();

        }
        if (in_array(4, $user_type) && in_array(3, $user_type)) {
            $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->whereIn('work', [3, 4])->orderBy('id', 'DESC')->get();
            $warehouse_branchs = Warehouse_branche::where('company_id', Auth()->user()->company_id)->get();

        }

        if ($request->exists('type')) {
            $from = $request->get('from');
            $to = $request->get('to');
            $singelClient = $request->get('client_id');
            $warehouse_branch = $request->get('warhouse_id');
            $packages_goods = Client_packages_good::where('company_id', Auth()->user()->company_id);
            if ($from != null && $to != null) {
                if ($request->type == 'ship') {

                    $packages_goods = $packages_goods->whereDate('updated_at', '>=', $from)
                        ->whereDate('updated_at', '<=', $to);

                } else {
                    $packages_goods = $packages_goods->whereDate('updated_at', '>=', $from)
                        ->whereDate('updated_at', '<=', $to);
                }
            }
            if ($singelClient != null) {
                $packages_goods->where('client_id', $singelClient);
            }
            $packagesGoods=$packages_goods->get();

           

            $totalGoodsCount = $packagesGoods->sum(function ($package) {
                return $package->number;
            });
            $packages_goods = $packages_goods->orderBy('id','DESC')->paginate(25);

            return view('admin.packages_goods.search', compact('packages_goods', 'totalGoodsCount', 'clients', 'from', 'to', 'singelClient'));

        } else {

            return view('admin.packages_goods.search', compact('clients'));
        }

    }

    public function scan_details($id){
        $packages_goods=Client_packages_good::where('company_id',Auth()->user()->company_id)->where('order_id',$id)->paginate(25);
        return view('admin.packages_goods.scan_details', compact('packages_goods'));

    }
}
