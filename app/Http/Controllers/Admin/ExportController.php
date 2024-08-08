<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;


class ExportController extends Controller
{
    public function index(request $request)
    {
      
        return Excel::download(new OrdersExport($request), 'orders.xlsx');
    
    
    }


}