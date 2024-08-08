<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\DailyReportCollection;
use App\Http\Resources\DelegateClientResource;
use App\Models\DailyReport;
use App\Models\Delegate_client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (Auth()->user()->show_report == 0) {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.You do not have permission to reports'),
            ], 503);

        }
        $rules = [
            'client_id' => 'required|numeric',
            'Recipient' => 'required|numeric',
            'Received' => 'required|numeric',
            'Returned' => 'required|numeric',
            'total' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        }

        $date = date('Y-m-d');
        $delegateData = $request->all();
        $delegateData['delegate_id'] = $user->id;
        $delegateData['date'] = $date;
        $report = DailyReport::where('delegate_id', $user->id)->where('client_id', $request->client_id)->whereDate('date', $date)->first();
        if ($report != null) {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.A report has already been created'),

            ], 500);
        }
        $delegateData['company_id'] = $user->company_id;

        $delegate = DailyReport::create($delegateData);

        if ($delegate) {
            return response()->json([
                'success' => 1,
                'message' => __('api_massage.Saved successfully'),

            ], 200);

        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.try again'),
            ], 500);

        }
    }

    //
    public function update(Request $request)
    {
        $user = Auth::user();
        if (Auth()->user()->show_report == 0) {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.You do not have permission to reports'),
            ], 503);

        }
        $rules = [
            'report_id' => 'required',
            'Recipient' => 'required',
            'Received' => 'required',
            'Returned' => 'required',
            'total' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        }
        if ($request->date == null) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }
        $report = DailyReport::find($request->report_id);
        if ($report) {

            $delegateData = $request->all();
            $update = $report->update($request->all());

            if ($update) {
                return response()->json([
                    'success' => 1,
                    'message' => __('api_massage.Saved successfully'),
                ], 200);

            } else {
                return response()->json([
                    'success' => 0,
                    'message' => __('api_massage.try again'),
                ], 500);

            }
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.No found report'),
            ], 500);

        }
    }

    //
    public function index()
    {
        $user = auth()->user();
        if ($user->show_report == 1) {

            if ($user) {
                return new DailyReportCollection(DailyReport::where('delegate_id', $user->id)->orderBy('id', 'desc')->paginate(10));
            } else {
                return response()->json([
                    'success' => 0,
                    'message' => __('api_massage.Invalid Authentication'),
                ], 503);
            }
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.You do not have permission to reports'),
            ], 503);
        }

    }

    public function search(Request $request)
    {
        $user = auth()->user();
        if ($user->show_report == 1) {

            if ($user) {

                $Reports = DailyReport::query();
                $Reports = $Reports->where('delegate_id', $user->id)->orderBy('id', 'desc');
                if (! empty($request->client_id)) {
                    $Reports->where('client_id', $request->client_id);
                }
                if (! empty($request->from) && ! empty($request->to)) {
                    $Reports = $Reports->whereDate('date', '>=', $request->from)
                        ->whereDate('date', '<=', $request->to);

                }

                return new DailyReportCollection(($Reports->paginate(10)));

            } else {
                return response()->json([
                    'success' => 0,
                    'message' => __('api_massage.Invalid Authentication'),
                ], 503);
            }
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.You do not have permission to reports'),
            ], 503);
        }

    }

    public function Client_Delegate()
    {
        $user = auth()->user();
        if ($user) {
            $clients = DelegateClientResource::collection(Delegate_client::where('delegate_id', $user->id)->get());
            if (count($clients) > 0) {

                return response()->json([
                    'success' => 1,
                    'clients' => $clients,
                ], 200);
            } else {
                return response()->json([
                    'success' => 0,
                    'message' => __('api_massage.There are no clients for this delegate'),

                ], 200);
            }
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }
    }
}
