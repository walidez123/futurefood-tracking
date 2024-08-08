<?php

namespace App\Http\Controllers\Delegate;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\Delegate_client;
use App\Models\User;
use Illuminate\Http\Request;

class DayReportController extends Controller
{
    public function index(request $request)
    {
        if (Auth()->user()->show_report == 0) {
            return redirect()->route('delegate.dashboard');

        }
        $user = auth()->user();
        $reports = DailyReport::where('delegate_id', $user->id);
        if ($request->exists('type')) {

            $client_id = $request->get('client_id');
            $from = $request->get('from');
            $to = $request->get('to');

            if ($request->client_id != null) {
                $reports->where('client_id', $request->client_id);
            }
            if ($from != null && $to != null) {
                $reports = $reports->whereDate('date', '>=', $from)
                    ->whereDate('date', '<=', $to);

            }

            $clients = Delegate_client::where('delegate_id', $user->id)->get();
            $reports = $reports->paginate(25);

            return view('delegate.dayReport.index', compact('reports', 'to', 'from', 'clients', 'client_id'));

        }

        $user = auth()->user();
        $clients = Delegate_client::where('delegate_id', $user->id)->get();
        $reports = $reports->orderBy('id', 'DESC')->paginate(25);

        return view('delegate.dayReport.index', compact('clients', 'reports'));

    }

    public function create()
    {
        if (Auth()->user()->show_report == 0) {
            return redirect()->route('delegate.dashboard');

        }
        $user = auth()->user();
        $clients = Delegate_client::where('delegate_id', $user->id)->get();
        $from = date('Y-m-d');

        return view('delegate.dayReport.create', compact('clients', 'from'));

    }

    public function edit($id)
    {
        if (Auth()->user()->show_report == 0) {
            return redirect()->route('delegate.dashboard');

        }
        $user = auth()->user();

        $Daily_report = DailyReport::findOrFail($id);
        if ($Daily_report) {
            $from = date('Y-m-d');
            $client = User::where('id', $Daily_report->client_id)->first();
            $clients = Delegate_client::where('delegate_id', $user->id)->get();

            return view('delegate.dayReport.edit', compact('client', 'from', 'Daily_report', 'clients'));

        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth()->user()->show_report == 0) {
            return redirect()->route('delegate.dashboard');

        }
        $user = auth()->user();

        $delegateData = $request->all();
        $delegateData['delegate_id'] = $user->id;
        $Daily_report = DailyReport::findOrFail($id);
        $Daily_report->update($delegateData);

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

        return redirect()->route('DayReport.index')->with($notification);

    }

    public function store(request $request)
    {
        if (Auth()->user()->show_report == 0) {
            return redirect()->route('delegate.dashboard');

        }
        $user = auth()->user();

        $delegateData = $request->all();
        $delegateData['delegate_id'] = $user->id;
        $delegateData['company_id'] = $user->company_id;

        $report = DailyReport::where('delegate_id', $user->id)->where('client_id', $request->client_id)->where('date', $request->date)->first();
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

        return redirect()->route('DayReport.index')->with($notification);

    }
}
