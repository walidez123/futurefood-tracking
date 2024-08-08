<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\ProviderOrder;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request)
    {

        $companies = User::where('user_type', 'admin')->where('is_company', 1)->get();
        $statuses = Status::get();
        $startOfMonth = Carbon::now()->startOfMonth();
        $now = Carbon::now();
        $orderMonth = Order::whereBetween('created_at', [$startOfMonth, $now])->count();
        $orderMonthSalla = ProviderOrder::where('provider_name','salla')->whereBetween('created_at', [$startOfMonth, $now])->count();
        $orderMonthZid = ProviderOrder::where('provider_name','zid')->whereBetween('created_at', [$startOfMonth, $now])->count();
        $orderMonthFoodics = ProviderOrder::where('provider_name','foodics')->whereBetween('created_at', [$startOfMonth, $now])->count();

        $year = date('Y'); // Current year; adjust as necessary
        $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                            ->whereYear('created_at', $year)
                            ->groupBy('month')
                            ->orderBy('month', 'ASC')
                            ->get()
                            ->pluck('count', 'month');

       // Fill missing months with zero orders
            $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
           $monthlyData[$i] = $monthlyOrders->get($i, 0);
         }





        return view('super_admin.dashboard', compact('companies', 'statuses','orderMonth','orderMonthSalla','orderMonthZid','orderMonthFoodics','monthlyData'));
    }

    public function DailyReport()
    {

        $from = date('Y-m-d');
        $delegates = User::where('user_type', 'delegate')->orderBy('id', 'desc')->get();
        $reports = DailyReport::orderBy('id', 'DESC')->get();

        return view('admin.DailyReport.index', compact('delegates', 'from', 'reports'));
    }

    public function store(request $request)
    {
        $report = DailyReport::whereDate('date', $request->date)->where('delegate_id', $request->delegate_id)->where('client_id', $request->client_id)->first();
        if ($report == null) {
            $delegateData = $request->all();
            $delegate = DailyReport::create($delegateData);

            if ($delegate) {
                $notification = [
                    'message' => '<h3>Saved Successfully</h3>',
                    'alert-type' => 'success',
                ];
            } else {
                $notification = [
                    'message' => '<h3>Something wrong Please Try again later</h3>',
                    'alert-type' => 'error',
                ];
            }

        } else {
            $notification = [
                'message' => '<h3>يوجد تقرير يومى بنفس اليوم</h3>',
                'alert-type' => 'error',
            ];

        }

        return redirect()->route('DailyReport')->with($notification);

    }
}
