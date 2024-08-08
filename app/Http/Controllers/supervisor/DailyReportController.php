<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\Delegate_client;
use App\Models\User;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function index(request $request)
    {
        if (Auth()->user()->show_report == 0) {
            return redirect()->route('supervisor_DayReport.dashboard');

        }
        $user = auth()->user();
        $delegates = $user->SupervisorDelegate()->get();
        $Arraydelegates = $delegates->pluck('delegate_id')->toArray();
        $delegates = User::whereIn('id', $Arraydelegates)->get();
        $reports = DailyReport::whereIn('delegate_id', $Arraydelegates);
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

            $reports = $reports->paginate(25);

            return view('supervisor.dayReport.index', compact('reports', 'to', 'from', 'delegates', 'delegate_id'));

        }

        $user = auth()->user();

        $reports = $reports->orderBy('id', 'DESC')->paginate(25);

        return view('supervisor.dayReport.index', compact('delegates', 'reports'));

    }

    public function create()
    {
        if (Auth()->user()->show_report == 0) {
            return redirect()->route('delegate.dashboard');

        }
        $user = auth()->user();
        $from = date('Y-m-d');
        $delegates = $user->SupervisorDelegate()->get();
        $Arraydelegates = $delegates->pluck('delegate_id')->toArray();
        $delegates = User::whereIn('id', $Arraydelegates)->get();

        return view('supervisor.dayReport.create', compact('delegates', 'from'));

    }

    public function fetchClients(Request $request)
    {
        $delegateId = $request->input('delegate_id');
        $delegate = User::find($delegateId);
        dd($delegate); // Replace with your actual model

        return response()->json(['clients' => $delegate->clients]);
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
        $request->validate([
            'delegate_id' => 'required',
            'client_id' => 'required',
        ]);

        if (Auth()->user()->show_report == 0) {

            return redirect()->route('supervisor.dashboard');

        }
        $user = auth()->user();

        $delegateData = $request->all();
        $delegateData['company_id'] = $user->company_id;

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

        return redirect()->route('supervisor_DayReport.index')->with($notification);

    }
}
