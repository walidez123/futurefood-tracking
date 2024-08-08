<?php

namespace App\Http\Controllers\Client;

use App\Exports\DailyReportExportview;
use App\Http\Controllers\Controller;
use App\Models\User;
use Excel;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function export(Request $request)
    {

        $from = date('Y-m-d');

        return Excel::download(new DailyReportExportview($request), ''.$from.'التقرير اليومى.xlsx');

    }

    public function index(Request $request)
    {
        $user = Auth()->user();

        $reports = DailyReport::where('client_id', $user->id)->orderBy('id', 'DESC');
        if ($request->exists('type')) {

            $delegate_id = $request->get('delegate_id');
            $from = $request->get('from');
            $to = $request->get('to');
            if ($request->delegate_id != null) {
                $reports->where('delegate_id', $request->delegate_id);
            }

            if ($from != null && $to != null) {
                $reports = $reports->whereDate('date', '>=', $from)
                    ->whereDate('date', '<=', $to);

            }

            $delegates = User::where('user_type', 'delegate')->orderBy('id', 'desc')->get();
            $reports = $reports->paginate(25);

            return view('client.DailyReport.index', compact('reports', 'to', 'from', 'delegates', 'delegate_id'));

        }

        $delegates = User::where('user_type', 'delegate')->orderBy('id', 'desc')->get();

        $reports = $reports->paginate(25);

        return view('client.DailyReport.index', compact('delegates', 'reports'));
    }

    public function create()
    {

        $from = date('Y-m-d');
        $delegates = User::where('user_type', 'delegate')->orderBy('id', 'desc')->get();

        return view('admin.DailyReport.create', compact('delegates', 'from'));
    }

    public function store(request $request)
    {

        $delegateData = $request->all();
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
