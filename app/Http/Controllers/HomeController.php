<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Delegate_client;
use App\Models\Good;
use App\Models\Neighborhood;
use App\Models\Neighborhood_zone;
use App\Models\packages_goods;
use App\Models\Status;
use App\Models\User;
use App\Models\User_package;
use App\Models\Warehouse_content;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $locale = LaravelLocalization::getCurrentLocale();
        // dd($locale);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return redirect()->route('home');
    //     // return view('home');
    // }
    public function getregions($id, $lang)
    {

        $regions = Neighborhood::select('id', 'title', 'title_ar')->where('city_id', '=', $id)->get();
        $arr = [];
        if ($lang =="ar") {
            $arr[0] = "<option value='0'> أختر الحي </option>";

        } else {
            $arr[0] = "<option value='0'> select  neighborhood</option>";

        }

        foreach ($regions as $i => $model) {
            if ($lang == 'ar') {
                $arr[$i + 1] = "<option value='$model->id'> $model->title_ar </option>";

            } else {
                $arr[$i + 1] = "<option value='$model->id'> $model->title </option>";

            }

        }

        return response()->json($arr);

    }

    //
    public function client_assign_address($id, $lang)
    {

        $Addresss = Address::where('user_id', '=', $id)->get();
        $arr = [];
        if ($lang == 'ar') {
            $arr[0] = "<option value='0'> أختر العنوان </option>";

        } else {
            $arr[0] = "<option value='0'> select  address</option>";

        }

        foreach ($Addresss as $i => $model) {

            $arr[$i + 1] = "<option value='$model->id'> $model->address </option>";

        }

        return response()->json($arr);
    }

    //

    //
    public function getregionsZone($id,$lang)
    {

        $neighborhood_zones = Neighborhood_zone::where('company_id', Auth()->user()->company_id)->pluck('neighborhood_id')->toArray();
        $regions = Neighborhood::select('id', 'title','title_ar')->where('city_id', '=', $id)->whereNotIn('id', $neighborhood_zones)->get();
        $arr = [];
        if ($lang == 'ar') {
            $arr[0] = "<option value='0'> أختر الحي </option>";

        } else {
            $arr[0] = "<option value='0'>Select neighborhood </option>";

        }

        foreach ($regions as $i => $model) {

            if ($lang == 'ar') {
                $arr[$i + 1] = "<option value='$model->id'> $model->title_ar </option>";

            } else {
                $arr[$i + 1] = "<option value='$model->id'> $model->title </option>";

            }

        }

        return response()->json($arr);

    }

    //
    public function getregionsZoneedit($id, $zone,$lang)
    {

        $neighborhood_zones = Neighborhood_zone::where('company_id', Auth()->user()->company_id)->where('zone_id', '!=', $zone)->pluck('neighborhood_id')->toArray();
        $regions = Neighborhood::select('id', 'title','title_ar')->where('city_id', '=', $id)->whereNotIn('id', $neighborhood_zones)->get();
        $arr = [];
        if ($lang == 'ar') {
            $arr[0] = "<option value='0'> أختر الحي </option>";

        } else {
            $arr[0] = "<option value='0'>Select neighborhood </option>";

        }

        foreach ($regions as $i => $model) {

            if ($lang == 'ar') {
                $arr[$i + 1] = "<option value='$model->id'> $model->title_ar </option>";

            } else {
                $arr[$i + 1] = "<option value='$model->id'> $model->title </option>";

            }

        }

        return response()->json($arr);

    }

    //

    public function getclient($id, Request $request)
    {

        $clients = Delegate_client::where('delegate_id', $id)->get();
        $arr = [];

        if (count($clients) == 1) {
            $name = $clients[0]->user->store_name;
            $id = $clients[0]->user->id;

            $arr[0] = "<option value='$id'>  $name </option>";

        } else {
            $arr[0] = "<option value=''> أختر العميل </option>";
            foreach ($clients as $i => $model) {
                $name = $model->user->store_name;

                $arr[$i + 1] = "<option value='$model->client_id'> $name </option>";

            }

        }

        return response()->json($arr);

    }

    //
    public function getstatus($id, $lang)
    {
        if ($id == 1) {
            $statuses = Status::where('shop_appear', '1')->where('company_id', Auth()->user()->company_id)->get();

        } else {
            $statuses = Status::where('restaurant_appear', '1')->where('company_id', Auth()->user()->company_id)->get();

        }

        $arr = [];

        if ($lang == 'ar') {
            $arr[0] = "<option value=''> أختر الحالة </option>";

        } else {
            $arr[0] = "<option value=''> select status </option>";

        }

        foreach ($statuses as $i => $model) {

            $arr[$i + 1] = "<option value='$model->id'> $model->title </option>";

        }

        return response()->json($arr);

    }

    //

    public function getdelegate($id, $lang)
    {
            $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($id) {
                $query->where('work', $id);
            })->orderBy('id', 'desc')->get();

       
        $arr = [];

        if ($lang == 'ar') {
            $arr[0] = "<option value=''> أختر المندوب </option>";

        } else {
            $arr[0] = "<option value=''> select delegate </option>";

        }
        foreach ($delegates as $i => $model) {

            $arr[$i + 1] = "<option value='$model->id'> $model->name </option>";

        }

        return response()->json($arr);

    }

    public function clientAssign($id, $lang)
    {
        $delegates = User::where('user_type', 'client')->where('work', $id)->where('company_id', Auth()->user()->company_id)->get();

        $arr = [];

        if ($lang == 'ar') {
            $arr[0] = "<option value=''> أختر العميل </option>";

        } else {
            $arr[0] = "<option value=''> select client </option>";

        }            foreach ($delegates as $i => $model) {

            $arr[$i + 1] = "<option value='$model->id'> $model->name </option>";

        }

        return response()->json($arr);

    }

    public function Service_p($id, $lang)
    {
        $delegates = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'service_provider')->whereHas('user_works', function ($query) use ($id) {
            $query->where('work', $id);
        })->orderBy('id', 'desc')->get();

        $arr = [];

        if ($lang == 'ar') {
            $arr[0] = "<option value=''> أختر الشركة المشغلة </option>";

        } else {
            $arr[0] = "<option value=''> select service provider </option>";

        }            foreach ($delegates as $i => $model) {

            $arr[$i + 1] = "<option value='$model->id'> $model->name </option>";

        }

        return response()->json($arr);

    }

    public function getaddress($id, $lang)
    {
        $addresses = Address::where('user_id', $id)->get();

        $arr = [];
        if ($lang == 'ar') {
            $arr[0] = "<option value='0'>أختر العنوان</option>";

        } else {
            $arr[0] = "<option value='0'>select address</option>";

        }
        foreach ($addresses as $i => $model) {
            if ($model->city == null) {
                $city = '';
            } else {
                if ($lang == 'ar') {
                    $city = $model->city->title_ar;

                } else {
                    $city = $model->city->title;

                }

            }
            if ($model->neighborhood == null) {
                $neighborhood = '';
            } else {
                if ($lang == 'ar') {
                    $neighborhood = $model->neighborhood->title_ar;

                } else {
                    $neighborhood = $model->neighborhood->title;
                }
            }
            if ($model->main_address == 1) {
                $arr[$i + 1] = "<option selected  value='{$model->id}' data-store_address_id='$model->id' data-region='$neighborhood' data-city='$city' data-address1='$model->address' data-address2='$model->description' data-phone='$model->phone'>$model->address| $city | $model->description</option>";

            } else {
                $arr[$i + 1] = "<option   value='{$model->id}' data-store_address_id='$model->id' data-region='$neighborhood' data-city='$city' data-address1='$model->address' data-address2='$model->description' data-phone='$model->phone'>$model->address| $city | $model->description</option>";

            }


        }

        return response()->json($arr);

    }

    public function getcontent($type, $id)
    {
        $arr = [];

        if ($type == 1) {
            $arr[0] = "<option value='0'> أختر الستاند </option>";

            $content = Warehouse_content::where('warehouse_id', $id)->where('type', 'stand')->get();

        } elseif ($type == 2) {
            $arr[0] = "<option value='0'> أختر الدور </option>";

            $content = Warehouse_content::where('warehouse_id', $id)->where('type', 'floor')->get();

        } else {
            $arr[0] = "<option value='0'> أختر الطبلية </option>";

            $content = Warehouse_content::where('warehouse_id', $id)->where('type', 'package')->get();

        }

        foreach ($content as $i => $model) {

            $arr[$i + 1] = "<option value='$model->id'> $model->title </option>";

        }

        return response()->json($arr);

    }

    public function type_delegate_clients($type, $lang)
    {

        $arr = [];
        if ($lang == 'ar') {
            $arr[0] = "<option value=''>أختر عميل </option>";

        } else {
            $arr[0] = "<option value=''>select client</option>";

        }
        $type = explode(',', $type);
        
        $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->whereIn('work',$type)->orderBy('id', 'desc')->get();
        foreach ($clients as $i => $model) {

            $arr[$i + 1] = "<option value='$model->id'> $model->store_name </option>";

        }

        return response()->json($arr);

    }

    public function typedelegate_service_provider($type, $lang)
    {

        $arr = [];
        if ($lang == 'ar') {
            $arr[0] = "<option value=''>أختر الشركات المشغلة  </option>";

        } else {
            $arr[0] = "<option value=''>select service provider</option>";

        }

        $service_providers = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'service_provider')->whereHas('user_works', function ($query) use ($type) {
            $query->where('work', $type);
        })->orderBy('id', 'desc')->get();

        foreach ($service_providers as $i => $model) {

            $arr[$i + 1] = "<option value='$model->id'> $model->name </option>";

        }

        return response()->json($arr);
    }

    public function client_warehouse_packages($id)
    {
        $user = User::findOrFail($id);
        $packages = User_package::where('user_id', $user->id)->get();
        $total_area = $packages->sum('area');
        $label = "$total_area";

        return response()->json($label);


    }

    public function client_used_warehouse($id)
    {
        $user = User::findOrFail($id);
        $packages = User_package::where('user_id', $user->id)->get();
        $total_area = $packages->sum('area');
        //
        $packages_goods = packages_goods::where('client_id', $id)->get();
        if ($packages_goods !== null) {
            $packages = $packages_goods->sum('total_packages');
            $packages_area = $packages * 2;
            $free_area = $total_area - $packages_area;
        } else {
            $free_area = $total_area;
        }

        //
        $label = "$free_area";

        return response()->json($label);
        

    }

    public function warhouse_packages($id)
    {
        $packages = Warehouse_content::where('warehouse_id', $id)->where('type', 'package')->orderBy('id', 'desc')->get();
        $arr = [];

        foreach ($packages as $i => $model) {

            $arr[$i] = "<option value='$model->id'> $model->title </option>";

        }

        return response()->json($arr);

    }

    //

    public function autocomplete_good(Request $request)
    {
        $query = $request->get('query');
        $filterResult = Good::where('company_id', Auth()->user()->company_id)->where('SKUS', 'LIKE', '%'.$query.'%')->get();

        return response()->json($filterResult);
    }

    public function autocomplete_packages(Request $request)
    {
        $query = $request->get('query');
        $filterResult = Warehouse_content::where('title', 'LIKE', '%'.$query.'%')->get();

        return response()->json($filterResult);
    }

    public function client_goods($id, $lang)
    {
        $arr = [];
        if ($lang == 'ar') {
            $arr[0] = "<option value=''>  أختر  المنتج   </option>";

        } else {
            $arr[0] = "<option value=''>select goods</option>";

        }

        $client = User::where('id', $id)->first();

            $goods = Good::where('company_id', Auth()->user()->company_id)->where('client_id', $client->id)->get();
        
        foreach ($goods as $i => $model) {
            if ($lang == 'ar') {
                $title = $model->title_ar;
                $stok = 'فى المخزن';
            } else {
                $title = $model->title_en;
                $stok = 'In stock';
            }
            $sum = $model->Client_packages_goods->sum('number');
            $arr[$i + 1] = "<option   data-expiration-date='$model->has_expire_date' value='$model->id'>$stok($sum) | $model->SKUS  |  $title </option>";
        }

        return response()->json($arr);

    }

    //
}
