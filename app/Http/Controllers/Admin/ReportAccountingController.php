<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Exports\BalanceTransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Status;
use App\Models\City;
Use App\Models\User;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Accounting;

class ReportAccountingController extends Controller
{
    public function index(request $request)
    {
        $this->authorize('checkType', [User::class, $request->work_type]);

        $work_type = $request->work_type;
        if (($request->work_type == 1 && in_array('report_accounting_lastmile', app('User_permission'))) ||
        $request->work_type == 2 && in_array('report_accounting_resturant', app('User_permission')) ||
        $request->work_type == 4 && in_array('report_accounting_fulfillment', app('User_permission'))) {
        $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->where('work', $work_type)->get();
       
        return view('admin.AccountingReport.search', compact( 'work_type', 'clients'));

    } else {
        return redirect(url(Auth()->user()->user_type));
    }
              

      
    
    }

    public function cod(){

        if (in_array('report_accounting_cod', app('User_permission'))) 
        {
        $clients = User::where('user_type', 'client')->where('company_id', Auth()->user()->company_id)
        ->get();
        $cod='cod';
       
        return view('admin.AccountingReport.cod', compact( 'cod', 'clients'));

    } else {
        return redirect(url(Auth()->user()->user_type));
    }
    }

    public function store(request $request)
    {
       $today = (new \Carbon\Carbon)->today();

        $name=$today.'_Accounting.xlsx';
        $userID=$request->user_id;
        $user=User::findOrFail($userID);
        $name=$today.'_'.$user->name.'_Accounting.xlsx';


        return Excel::download(new BalanceTransactionExport($userID,$request),$name);

    }


}