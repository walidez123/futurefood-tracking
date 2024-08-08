<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use App\Models\ClientTransactions;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $delegates = $user->SupervisorDelegate()->get();
        $Arraydelegates = $delegates->pluck('id')->toArray();
        $ordersTodayshop = Order::whereIn('delegate_id', $Arraydelegates)->whereDate('pickup_date', date('Y-m-d'))->where('work_type', 1)->get();
        $ordersTodayres = Order::whereIn('delegate_id', $Arraydelegates)->whereDate('created_at', date('Y-m-d'))->where('work_type', 2)->get();

        $orders = Order::whereIn('delegate_id', $Arraydelegates)->get();

        // $ordersLastSixMonths  = DB::select("select DATE_FORMAT(created_at, '%Y-%m') as date, count(created_at) as count from orders WHERE delegate_id IN '.$Arraydelegates.' group by DATE_FORMAT(created_at, '%Y-%m') order by created_at desc limit 6");
        // $orderdate = collect([]);
        // $ordercount = collect([]);
        // for ($i=0; $i < count($ordersLastSixMonths) ; $i++) {
        //     $orderdate[] = $ordersLastSixMonths[$i]->date  ;
        //     $ordercount[]= $ordersLastSixMonths[$i]->count;
        // }

        $statuses = Status::where('company_id', $user->company_id)->orderBy('sort', 'ASC')->get();

        return view('supervisor.dashboard', compact('delegates', 'statuses', 'Arraydelegates', 'orders', 'ordersTodayres', 'ordersTodayshop'));

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
