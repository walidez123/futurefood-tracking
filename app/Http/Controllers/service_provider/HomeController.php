<?php

namespace App\Http\Controllers\service_provider;

use App\Http\Controllers\Controller;
use App\Models\ClientTransactions;
use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $user = auth()->user();
        $works = auth()->user()->user_works->pluck('work')->toArray();
        $delegates = $user->Service_providerDelegate()->get();
        $Arraydelegates = $delegates->pluck('id')->toArray();
        $ordersTodayRestaurant = Order::whereIn('delegate_id', $Arraydelegates)->where('work_type', 2)->orWhere('service_provider_id', Auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->where('work_type', 1)->get();
        $ordersTodayres = Order::whereIn('delegate_id', $Arraydelegates)->where('work_type', 1)->orWhere('service_provider_id', Auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->where('work_type', 2)->get();
        $ordersTodayFulfement = Order::whereIn('delegate_id', $Arraydelegates)->where('work_type', 4)->orWhere('service_provider_id', Auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->where('work_type', 1)->get();

        $orders = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->get();
        $ordersCustomer = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->where('work_type', 1)->where('company_id', auth()->user()->company_id)->count();
        $ordersrestaurant = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->where('work_type', 2)->where('company_id', auth()->user()->company_id)->count();
        $ordersFulfement = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->where('work_type', 4)->where('company_id', auth()->user()->company_id)->count();

        $ordersShop = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->where('work_type', 1)->where('company_id', auth()->user()->company_id)->count();
        $statuses = Status::where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get();
        $balance = DB::table('client_transactions')->select([DB::raw('SUM(debtor - creditor) as total')])
            ->where('user_id', $user->id)
            ->where('deleted_at', null)
            ->first();
        $balance = $balance->total;
        $statuses = Status::where('company_id', auth()->user()->company_id)->orderBy('sort', 'ASC')->get();
        $today = (new \Carbon\Carbon)->today()->toDateString();
        $yesterday = (new \Carbon\Carbon)->yesterday();
        $month = (new \Carbon\Carbon)->subMonth()->submonths(1);
        $statuesChart = [];
        $ordersChart = [];
        $ordersChart = [];
        $orderChartToday = [];
        $orderChartYestrday = [];
        $orderChartMonth = [];
        for ($i = 0; $i < count($statuses); $i++) {
            $statuesChart[] = $statuses[$i]->trans('title');
            $ordersChart[] = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->where('status_id', $statuses[$i]->id)->count();
            $orderChartToday[] = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->where('status_id', $statuses[$i]->id)->whereDate('updated_at', $today)->count();
            $orderChartYestrday[] = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->where('status_id', $statuses[$i]->id)->whereDate('updated_at', $yesterday)->count();
            $orderChartMonth[] = Order::whereIn('delegate_id', $Arraydelegates)->orWhere('service_provider_id', Auth()->user()->id)->where('status_id', $statuses[$i]->id)->whereDate('updated_at', '>', $month)->count();

        }

        return view('service_provider.dashboard', compact('ordersFulfement', 'ordersTodayFulfement', 'works', 'orderChartMonth', 'orderChartYestrday', 'orderChartToday', 'ordersChart', 'statuesChart', 'balance', 'delegates', 'statuses', 'Arraydelegates', 'orders', 'ordersTodayres', 'ordersTodayRestaurant', 'ordersCustomer', 'ordersrestaurant'));
    }

    public function transactions(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $user = Auth()->user();
        if ($user) {

            $transactions = ClientTransactions::where('user_id', $user->id)->orderBy('id', 'DESC');
            if ($from != null && $to != null) {
                $transactions = $transactions->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to);
            }
            $count_creditor = $transactions->sum('creditor');
            $count_debtor = $transactions->sum('debtor');

            $transactions = $transactions->paginate(15);

            return view('service_provider.balance-transactions', compact('transactions', 'user', 'count_debtor', 'count_creditor'));
        } else {
            abort(404);
        }
    }

    public function transactions_delegate()
    {
        $delegates = User::orderBy('id', 'desc')->where('service_provider', Auth()->user()->id)->where('company_id', Auth()->user()->company_id)->where('user_type', 'delegate')->paginate(15);
        if (! empty($delegates)) {
            foreach ($delegates as $client) {
                $transactions = ClientTransactions::where('user_id', $client->id);
                $client->count_creditor = $transactions->sum('creditor');

                $client->count_debtor = $transactions->sum('debtor');
            }

        }

        return view('service_provider.delegates_balances', compact('delegates'));

    }

    public function transactions_delegate_details(Request $request, $id)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $delegate = User::orderBy('id', 'desc')->where('id', $id)->where('user_type', 'delegate')->first();
        if ($delegate) {
            $transactions = ClientTransactions::orderBy('id', 'desc')->where('user_id', $id);
            if ($from != null && $to != null) {
                $transactions = $transactions->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to);
            }
            $alltransactions = $transactions->orderBy('id', 'desc')->paginate(50);
            $count_creditor = $transactions->sum('creditor');
            $count_debtor = $transactions->sum('debtor');

            $count_order_creditor = $transactions->whereNotNull('order_id')->sum('creditor');

            $count_order_debtor = $transactions->whereNotNull('order_id')->sum('debtor');

            $transactions = $transactions->paginate(50);

            return view('admin.delegates.balance-transactions', compact('alltransactions', 'transactions', 'delegate', 'from', 'to', 'count_debtor', 'count_creditor', 'count_order_creditor', 'count_order_debtor'));
        } else {
            abort(404);
        }
    }
}
