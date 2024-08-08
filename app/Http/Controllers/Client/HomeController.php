<?php

namespace App\Http\Controllers\Client;

use App\Charts\OrderChart;
use App\Http\Controllers\Controller;
use App\Models\ClientTransactions;
use App\Models\packages_goods;
use App\Models\PaletteSubscription;
use App\Models\Status;
use App\Models\User_package;
use App\Models\Good;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\BalanceTransactionExport;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('terms');
    }

    public function index()
    {
        $user = Auth()->user();
        $now = Carbon::now();
        $latestOrders = $user->orders()->orderBy('updated_at', 'DESC')->get();
        $monthlyOrders = $user->orders()->whereMonth('updated_at', $now->month)->get();
        $deliverdOrders = $user->orders()->whereHas('status', function ($query) {
            $query->whereIn('title', ['Delivered', 'تم التوصيل']);
        })->get();

        $id = $user->id;
        $transactions = ClientTransactions::where('user_id', $id);

        $pallet_subscriptions = PaletteSubscription::whereHas('clientPackagesGoods', function ($query) use ($id) {
            $query->where('client_id', $id);
        })->orderBy('id', 'desc')->paginate(50);

        $pallet_recives = PaletteSubscription::whereHas('pickupOrder', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->orderBy('id', 'desc')->paginate(50);

        $balance =  $transactions->sum('creditor') + $pallet_subscriptions->sum('cost') + $pallet_recives->sum('cost');

        $ordersLastSixMonths = DB::select("select DATE_FORMAT(created_at, '%Y-%m') as date, count(created_at) as count from orders where user_id=".auth()->user()->id." group by DATE_FORMAT(created_at, '%Y-%m') ORDER BY updated_at DESC limit 6");
        $orderdate = collect([]);
        $ordercount = collect([]);
        for ($i = 0; $i < count($ordersLastSixMonths); $i++) {
            $orderdate[] = $ordersLastSixMonths[$i]->date;
            $ordercount[] = $ordersLastSixMonths[$i]->count;
        }

        $orderChart = new OrderChart;
        $orderChart->labels($orderdate);
        $orderChart->dataset(__('app.orders', ['attribute' => '']), 'bar', $ordercount)->options([
            'backgroundColor' => '#f39c12',
        ]);

        if( Auth()->user()->work==1)
        {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('shop_appear',1)->where('client_appear',1)->orderBy('sort', 'ASC')->get();

        }
        if( Auth()->user()->work==2)
        {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('restaurant_appear',1)->where('client_appear',1)->orderBy('sort', 'ASC')->get();

        }
        if( Auth()->user()->work==3)
        {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('storehouse_appear',1)->where('client_appear',1)->orderBy('sort', 'ASC')->get();

        }
        if( Auth()->user()->work==4)
        {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->where('fulfillment_appear',1)->where('client_appear',1)->orderBy('sort', 'ASC')->get();

        }

        $goods = Good::where('client_id', Auth()->user()->id)->count();
        //
        $packages = User_package::where('user_id', Auth()->user()->id)->get();
        $total_area = $packages->sum('area');
        //
        $packages_goods = packages_goods::where('client_id', Auth()->user()->id)->get();
        if ($packages_goods !== null) {
            $packages = $packages_goods->sum('total_packages');
            $packages_area = $packages * 2;
            $free_area = $total_area - $packages_area;
        } else {
            $free_area = $total_area;
        }
        $packageCount = User_package::where('user_id', Auth()->user()->id)->count();

        //

        return view('client.dashboard', compact('latestOrders', 'monthlyOrders', 'deliverdOrders', 'orderChart', 'balance', 'statuses', 'free_area', 'total_area', 'packages_area', 'packageCount', 'goods'));
    }

    public function transactions(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');

        $client = Auth()->user();

        if ($client) {
            switch ($request->input('action')) {
                case 'export':
                    $file_name=$client->name.'_transactions.xlsx';
                    return Excel::download(new BalanceTransactionExport($client->id,$request),$file_name);                
                    break;
            }
            $transactions = ClientTransactions::where('user_id', $client->id)->where(function ($query) {
                $query->where('debtor', '!=', 0)
                    ->orWhere('creditor', '!=', 0);
            });
            $id = $client->id;
            $pallet_subscriptions = PaletteSubscription::whereHas('clientPackagesGoods', function ($query) use ($id) {
                $query->where('client_id', $id);
            });

            $pallet_recives = PaletteSubscription::whereHas('pickupOrder', function ($query) use ($id) {
                $query->where('user_id', $id);
            });

            if ($from != null && $to != null) {
                $transactions = $transactions->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to)
                    ->orderBy('id', 'desc')
                    ->paginate(200);
            
                $id = $client->id;
                $pallet_subscriptions = PaletteSubscription::whereHas('clientPackagesGoods', function ($query) use ($id) {
                        $query->where('client_id', $id);
                    })->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to)
                    ->orderBy('id', 'desc')
                    ->paginate(200);
            
                $pallet_recives = PaletteSubscription::whereHas('pickupOrder', function ($query) use ($id) {
                        $query->where('user_id', $id);
                    })->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to)
                    ->orderBy('id', 'desc')
                    ->paginate(200);
            } else {
                $transactions = $transactions->orderBy('id', 'desc')->paginate(200);
                $id = $client->id;
                $pallet_subscriptions = PaletteSubscription::whereHas('clientPackagesGoods', function ($query) use ($id) {
                        $query->where('client_id', $id);
                    })->orderBy('id', 'desc')->paginate(200);
            
                $pallet_recives = PaletteSubscription::whereHas('pickupOrder', function ($query) use ($id) {
                        $query->where('user_id', $id);
                    })->orderBy('id', 'desc')->paginate(200);
            }

            $count_order_debtor = $transactions->whereNotNull('order_id')->sum('debtor');
            $count_creditor = $transactions->sum('creditor') + $pallet_subscriptions->sum('cost') + $pallet_recives->sum('cost');
            $count_debtor = $transactions->sum('debtor');

            return view('client.balance-transactions', compact('transactions','pallet_recives','pallet_subscriptions', 'client', 'from', 'to', 'count_debtor', 'count_creditor'));
        } else {
            abort(404);
        }
    }
}
