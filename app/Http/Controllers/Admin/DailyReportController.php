<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DailyReportExportview;
use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\User;
use Excel;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:show_dailyReport', ['only' => 'index', 'show']);
        $this->middleware('permission:add_dailyReport', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_dailyReport', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_dailyReport', ['only' => 'destroy']);

    }

    public function export(Request $request)
    {

        $from = date('Y-m-d');

        return Excel::download(new DailyReportExportview($request), ''.$from.'التقرير اليومى.xlsx');

    }

    public function index(Request $request)
    {
        $reports = DailyReport::where('company_id', Auth()->user()->company_id)->orderBy('id', 'DESC');
        if ($request->exists('type')) {

            $delegate_id = $request->get('delegate_id');
            $client_id = $request->get('client_id');
            $from = $request->get('from');
            $to = $request->get('to');
            if ($request->delegate_id != null) {
                $reports->where('delegate_id', $request->delegate_id);
            }
            if ($request->client_id != null) {
                $reports->where('client_id', $request->client_id);
            }
            if ($from != null && $to != null) {
                $reports = $reports->whereDate('date', '>=', $from)
                    ->whereDate('date', '<=', $to);

            }

            $delegates = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'delegate')->orderBy('id', 'desc')->get();
            $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->orderBy('id', 'desc')->get();
            $maxRecipient = $reports->sum('Recipient');
            $maxReceived = $reports->sum('Received');
            $maxReturned = $reports->sum('Returned');
            $maxtotal = $reports->sum('total');
            $reports = $reports->paginate(25);

            return view('admin.DailyReport.index', compact('maxtotal', 'maxReturned', 'maxReceived', 'maxRecipient', 'reports', 'to', 'from', 'clients', 'client_id', 'delegates', 'delegate_id'));

        }

        $delegates = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'delegate')->orderBy('id', 'desc')->get();
        $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->orderBy('id', 'desc')->get();
        $month = (new \Carbon\Carbon)->now()->startOfMonth();

        $reports = $reports->whereDate('updated_at', '>', $month);

        $maxRecipient = $reports->sum('Recipient');
        $maxReceived = $reports->sum('Received');
        $maxReturned = $reports->sum('Returned');
        $maxtotal = $reports->sum('total');
        $reports = $reports->paginate(25);

        return view('admin.DailyReport.index', compact('maxtotal', 'maxReturned', 'maxReceived', 'maxRecipient', 'delegates', 'clients', 'reports'));
    }

    public function create()
    {

        $from = date('Y-m-d');
        $delegates = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'delegate')->orderBy('id', 'desc')->get();

        return view('admin.DailyReport.create', compact('delegates', 'from'));
    }

    public function store(request $request)
    {

        $delegateData = $request->all();
        $delegateData['company_id'] = Auth()->user()->company_id;
        $report = DailyReport::where('delegate_id', $request->delegate_id)->where('client_id', $request->client_id)->where('date', $request->date)->first();
        if ($report != null) {
            return redirect()->back()->with('error', 'تم أنشاء تقرير بنفس اليوم من قبل ');

        }

        $delegate = DailyReport::create($delegateData);

        if ($delegate) {
            $notification = [
                'message' => '<h3>Saved Successfully</h3>',
                'alert-type' => 'success',
            ];
        } else {
            $notification = [
                'message' => '<h3>Something wrong Please Try again later</h3>',
                'alert-type' => 'error',
            ];
        }

        return redirect()->route('DailyReport.index')->with($notification);

    }

    public function edit($id)
    {
        $Daily_report = DailyReport::findOrFail($id);
        if ($Daily_report) {
            $from = date('Y-m-d');
            $delegates = User::where('user_type', 'delegate')->orderBy('id', 'desc')->get();
            $client = User::where('id', $Daily_report->client_id)->first();

            return view('admin.DailyReport.edit', compact('Daily_report', 'delegates', 'from', 'client'));
        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {

        $delegateData = $request->all();
        //
        $report = DailyReport::where('delegate_id', $request->delegate_id)->where('client_id', $request->client_id)->where('date', $request->date)->first();
        if ($report != null && $report->id != $id) {
            return redirect()->back()->with('error', 'تم أنشاء تقرير بنفس اليوم من قبل ');

        }
        //
        $Daily_report = DailyReport::findOrFail($id);
        $Daily_report->update($request->all());

        if ($Daily_report) {
            $notification = [
                'message' => '<h3>Saved Successfully</h3>',
                'alert-type' => 'success',
            ];
        } else {
            $notification = [
                'message' => '<h3>Something wrong Please Try again later</h3>',
                'alert-type' => 'error',
            ];
        }

        return redirect()->route('DailyReport.index')->with($notification);

    }

    public function destroy($id)
    {
        DailyReport::findOrFail($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
