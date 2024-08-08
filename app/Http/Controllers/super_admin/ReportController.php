<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyTransaction;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $companies = User::where('user_type', 'admin')->where('is_company', 1)->orderBy('id', 'desc')->paginate(25);

        return view('super_admin.reports.index', compact('companies'));
    }

    public function show(User $company)
    {
        $transactions = CompanyTransaction::where('user_id', $company)->where('created_at', now()->month);
        $count_creditor = $transactions->sum('creditor');
        $count_debtor = $transactions->sum('debtor');
        $count_order_creditor = $transactions->whereNotNull('order_id')->sum('creditor');
        $count_order_debtor = $transactions->whereNotNull('order_id')->sum('debtor');

        // Retrieve monthly order data for the specified company
        $ordersCount = Order::where('company_id', $company)
            ->where('created_at', Carbon::now()->year)->where('created_at', Carbon::now()->month)
            ->get();

        $usersCount = User::where('company_id', $company)
            ->where('created_at', Carbon::now()->year)->where('created_at', Carbon::now()->month)
            ->get();

        return view('super_admin.reports.show', compact(
            'company', 'count_creditor', 'count_debtor',
            'count_order_creditor', 'count_order_debtor',
            'ordersCount', 'usersCount'));
    }
}
