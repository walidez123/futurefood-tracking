<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Exports\OrdersExportDilvary;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Status;
use App\Models\City;
Use App\Models\User;



class orderDerlivaryReportController extends Controller
{
    public function index(request $request)
    {
        $this->authorize('checkType', [User::class, $request->work_type]);

        $work_type = $request->work_type;
        if (($request->work_type == 1 && in_array('show_order', app('User_permission'))) ||
        $request->work_type == 2 && in_array('show_order_res', app('User_permission')) ||
        $request->work_type == 3 && in_array('show_order_warehouse', app('User_permission')) ||
        $request->work_type == 4 && in_array('show_order_fulfillment', app('User_permission'))) {
       
        $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
        if ($request->exists('type')) {
            $from = $request->get('from');
            $to = $request->get('to');
            $user_id = $request->get('user_id');
            $orders = Order::where('company_id', Auth()->user()->company_id)->where('is_returned', 0)->where('work_type',$request->work_type);
            
            if ($from != null && $to != null) {

                  
                    $orders = $orders->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to);
                
            } 
            if ($user_id != null) {
                $orders->where('user_id', $user_id);
            }

            $client=User::findOrFail($user_id);
            $orders=$orders->where('status_id',$client->cost_calc_status_id)->paginate(50);
            return view('admin.OrderReport.search_delivary_order', compact( 'work_type', 'clients','orders'));



        }
       
        return view('admin.OrderReport.search_delivary_order', compact( 'work_type', 'clients'));

    } else {
        return redirect(url(Auth()->user()->user_type));
    }
              

      
    
    }

    public function store(request $request)
    {
        $today = (new \Carbon\Carbon)->today();

        $name=$today.'Orders.xlsx';
        return Excel::download(new OrdersExportDilvary($request),$name);

    }


}