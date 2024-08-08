<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Exports\OrdersExportClient;
use Maatwebsite\Excel\Facades\Excel;


class ExportController extends Controller
{
    public function index(request $request)
    {
      
        return Excel::download(new OrdersExportClient($request), 'orders.xlsx');
    
    
    }


}