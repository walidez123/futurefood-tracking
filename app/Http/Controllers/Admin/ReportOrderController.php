<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Status;
use App\Models\City;
use App\Models\User;
use App\Models\CompanyServiceProvider;




class ReportOrderController extends Controller
{
    public function index(request $request)
    {
        $this->authorize('checkType', [User::class, $request->work_type]);

        $work_type = $request->work_type;
        if (($request->work_type == 1 && in_array('show_order', app('User_permission'))) ||
        $request->work_type == 2 && in_array('show_order_res', app('User_permission')) ||
        $request->work_type == 3 && in_array('show_order_warehouse', app('User_permission')) ||
        $request->work_type == 4 && in_array('show_order_fulfillment', app('User_permission'))) {
        

        if ($work_type == 1) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear', 1)->orderBy('sort', 'ASC')->get();

        } elseif ($work_type == 2) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear', 1)->orderBy('sort', 'ASC')->get();

        } elseif ($work_type == 3) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('storehouse_appear', 1)->orderBy('sort', 'ASC')->get();

        } elseif ($work_type == 4) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear', 1)->orderBy('sort', 'ASC')->get();

        }

        $service_providers = CompanyServiceProvider::where('company_id', Auth()->user()->company_id)->where('is_active', 1)
        ->whereHas('user_works', function ($query) use ($work_type) {
            $query->where('work', $work_type);
        })->orderBy('id', 'desc')->get();

            $cities = City::get();
        $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
        $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
            $query->where('work', $work_type);
        })->orderBy('id', 'desc')->get();  
        return view('admin.OrderReport.search', compact( 'work_type', 'clients', 'statuses', 'delegates', 'cities', 'service_providers'));

    } else {
        return redirect(url(Auth()->user()->user_type));
    }
              

      
    
    }

    public function store(request $request)
    {
        $today = (new \Carbon\Carbon)->today();

        $name=$today.'Orders.xlsx';
        return Excel::download(new OrdersExport($request),$name);

    }


}