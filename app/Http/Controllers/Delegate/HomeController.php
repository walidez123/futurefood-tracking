<?php

namespace App\Http\Controllers\Delegate;

use App\Http\Controllers\Controller;
use App\Models\ClientTransactions;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $ordersToday = $user->ordersDelegate()->PickupToday()->get();
        $balance = DB::table('client_transactions')->select([DB::raw('SUM(debtor - creditor) as total')])
            ->where('user_id', $user->id)
            ->where('deleted_at', null)
            ->first();
        $balance = $balance->total;
        $ordersLastSixMonths = DB::select("select DATE_FORMAT(created_at, '%Y-%m') as date, count(created_at) as count from orders where delegate_id=".auth()->user()->id." group by DATE_FORMAT(created_at, '%Y-%m') order by created_at desc limit 6");
        $orderdate = collect([]);
        $ordercount = collect([]);
        for ($i = 0; $i < count($ordersLastSixMonths); $i++) {
            $orderdate[] = $ordersLastSixMonths[$i]->date;
            $ordercount[] = $ordersLastSixMonths[$i]->count;
        }

        $statuses = Status::where('company_id', Auth()->user()->company_id)->where('delegate_appear', 1)->orderBy('sort', 'ASC')->get();

        return view('delegate.dashboard', compact('ordersToday', 'balance', 'statuses'));

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

            return view('delegate.balance-transactions', compact('transactions', 'user', 'count_debtor', 'count_creditor'));
        } else {
            abort(404);
        }
    }
}
