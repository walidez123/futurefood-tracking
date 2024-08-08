<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientTransactions;
use App\Models\Invoice_order;
use App\Models\Invoices_details;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {

        $user = Auth()->user();

        if ($request->exists('from')) {

            $from = $request->get('from');
            $to = $request->get('to');
            if ($from != null && $to != null) {
                $Invoices = Invoices_details::where('client_id', $user->id)->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to);

            } else {
                $Invoices = Invoices_details::orderBy('created_at', 'DESC');
            }

            //bydate
            $Invoices = $Invoices->where('deleted_at', null)->orderBy('id', 'desc')->paginate(50);

            return view('client.reports.index', compact('Invoices'));
        }

        $Invoices = Invoices_details::where('client_id', $user->id)->orderBy('id', 'desc')->paginate(50);

        return view('client.reports.index', compact('Invoices'));

    }

    //
    public function create(Request $request)
    {

        $from = $request->get('from');
        $to = $request->get('to');
        $user_id = $request->get('user_id');
        $user = User::where('id', $user_id)->where('user_type', 'client')->where('is_active', '1')->first();
        if ($from != null && $to != null) {
            if ($user->work == 1) {
                $orders = Order::whereDate('pickup_date', '>=', $from)
                    ->whereDate('pickup_date', '<=', $to);
            } else {
                $orders = Order::whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to);
            }
        } else {
            $orders = Order::orderBy('pickup_date', 'DESC');
        }
        if ($request->user_id != null) {
            $orders->where('user_id', $request->user_id);
        }
        $Invoice_order = Invoice_order::where('deleted_at', '!=', null)->pluck('order_id')->toArray();
        $order_tras = ClientTransactions::where('deleted_at', '!=', null)->pluck('order_id')->toArray();
        $orders = $orders->whereNotIn('id', $Invoice_order)->whereIn('id', $order_tras)->orderBy('id', 'desc')->get();
        $lastInvID = Invoices_details::orderBy('id', 'DESC')->pluck('id')->first();
        $newInvID = $lastInvID + 1;
        $InvoceNum = 'R'.$newInvID;

        return view('client.reports.report', compact('orders', 'user', 'from', 'to', 'InvoceNum'));
    }

    public function store(request $request)
    {

        $from = $request->get('from');
        $to = $request->get('to');
        $user_id = $request->get('client_id');
        $user = User::where('id', $user_id)->where('user_type', 'client')->where('is_active', '1')->first();

        if ($from != null && $to != null) {
            if ($user->work == 1) {
                $orders = Order::whereDate('pickup_date', '>=', $from)
                    ->whereDate('pickup_date', '<=', $to);
            } else {
                $orders = Order::whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to);
            }
        } else {
            $orders = Order::orderBy('pickup_date', 'DESC');
        }
        if ($request->client_id != null) {
            $orders->where('user_id', $request->client_id);
        }
        $Invoice_order = Invoice_order::where('deleted_at', '!=', null)->pluck('order_id')->toArray();
        $order_tras = ClientTransactions::where('deleted_at', '!=', null)->pluck('order_id')->toArray();
        $orders = $orders->whereNotIn('id', $Invoice_order)->whereIn('id', $order_tras)->orderBy('id', 'desc')->get();
        $InvoiceData = $request->all();
        $Invoice = Invoices_details::create($InvoiceData);
        foreach ($orders as $order) {
            $Invoice_order = new Invoice_order();
            $Invoice_order->order_id = $order->id;
            $Invoice_order->invoice_id = $Invoice->id;
            $Invoice_order->save();
        }

        $notification = [
            'message' => '<h3>تم حفظ الفاتورة </h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('report.index')->with($notification);
    }

    public function show($id)
    {
        $Invoices_details = Invoices_details::findOrFail($id);
        $Invoice_order = Invoice_order::where('invoice_id', $id)->pluck('order_id')->toArray();
        $orders = Order::WhereIn('id', $Invoice_order)->orderBy('id', 'desc')->get();
        $user = User::where('id', $Invoices_details->client_id)->first();

        return view('client.reports.show', compact('Invoices_details', 'user', 'orders'));

    }

    public function destroy($id)
    {
        Invoices_details::findOrFail($id)->delete();
        Invoice_order::where('invoice_id', $id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('report.index')->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //

    public function invoice($id)
    {
        $invoice = Invoices_details::find($id);
        $client = User::where('user_type', 'client')->where('id', $invoice->client_id)->first();

        return view('client.reports.invoice', compact('invoice', 'client'));
    }

    public function array_remove_by_value($array, $value)
    {
        return array_values(array_diff($array, [$value]));
    }

    public function generate($id)
    {

        $invoice = Invoices_details::find($id);
        $client = User::where('user_type', 'client')->where('id', $invoice->client_id)->first();

        $pdf = PDF::loadView('admin.pdf.invoice', compact('invoice', 'client'));
        $name = 'فاتورة ضريبة'.$invoice->InvoceNum.'.pdf';

        return $pdf->download($name);

    }

    public function reportpdf($id)
    {

        $Invoices_details = Invoices_details::findOrFail($id);
        $Invoice_order = Invoice_order::where('invoice_id', $id)->pluck('order_id')->toArray();
        $orders = Order::WhereIn('id', $Invoice_order)->orderBy('id', 'desc')->get();
        $user = User::where('id', $Invoices_details->client_id)->first();

        $pdf = PDF::loadView('admin.pdf.report', compact('user', 'orders', 'Invoices_details'));
        $name = 'فاتورة مفصلة'.$Invoices_details->InvoceNum.'.pdf';

        return $pdf->download($name);

    }
}
