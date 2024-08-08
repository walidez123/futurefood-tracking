<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    public function index(Request $request)
    {
        if (auth()->user()->company->read_terms == 0) {
            return redirect()->route('settings.edit.company');
        }
        $ordersToday = Order::CreatedToday()->where('company_id', auth()->user()->company_id)->get();
        $ordersTodayRes = Order::where('work_type', 2)->CreatedToday()->where('company_id', auth()->user()->company_id)->get();
        $ordersTodayShop = Order::where('work_type', 1)->CreatedToday()->where('company_id', auth()->user()->company_id)->get();
        $ordersTodayFulfillment = Order::where('work_type', 4)->CreatedToday()->where('company_id', auth()->user()->company_id)->get();
        $ordersShipToday = Order::PickupToday()->get();
        $today = (new \Carbon\Carbon)->today();
        $yesterday = (new \Carbon\Carbon)->yesterday();
        $month = (new \Carbon\Carbon)->subMonth()->submonths(1);
        $statuses = Status::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->orderBy('sort', 'ASC')->get();
        $statuesChart = [];
        $ordersChart = [];
        $ordersChart = [];
        $orderChartToday = [];
        $orderChartYestrday = [];
        $orderChartMonth = [];
        for ($i = 0; $i < count($statuses); $i++) {
            $statuesChart[] = $statuses[$i]->trans('title');
            $ordersChart[] = count($statuses[$i]->orders);
            $orderChartToday[] = $statuses[$i]->orders()->whereDate('updated_at', $today)->count();
            $orderChartYestrday[] = $statuses[$i]->orders()->whereDate('updated_at', $yesterday)->count();
            $orderChartMonth[] = $statuses[$i]->orders()->whereDate('updated_at', '>', $month)->count();

        }

        $ordersPieChart = Order::where('company_id', Auth()->user()->company_id)->selectRaw("amount_paid, COUNT(*) as total")
            ->groupBy('amount_paid')
            ->get();
        if ($ordersPieChart->isEmpty()) {
            $ordersPieChart = collect([
                (object)['amount_paid' => '0', 'total' => 0], // Unpaid
                (object)['amount_paid' => '1', 'total' => 0], // Paid
            ]);
        }

        return view('admin.dashboard', compact('ordersPieChart', 'ordersToday', 'ordersShipToday', 'ordersTodayRes', 'ordersTodayShop', 'ordersTodayFulfillment', 'statuses', 'statuesChart', 'ordersChart', 'orderChartMonth', 'orderChartYestrday', 'orderChartToday'));
    }
}
