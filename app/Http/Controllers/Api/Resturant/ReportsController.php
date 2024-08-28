<?php

namespace App\Http\Controllers\Api\Resturant;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientDelegateResource;
use App\Http\Resources\DailyReportCollection;
use App\Models\Delegate_client;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user) {
            return new DailyReportCollection(DailyReport::where('client_id', $user->id)->paginate(10));
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Authentication',
            ], 503);
        }

    }

    public function search(Request $request)
    {
        $user = auth()->user();

        if ($user) {

            $Reports = DailyReport::query();
            $Reports = $Reports->where('client_id', $user->id);
            if (! empty($request->delegate_id)) {
                $Reports->where('delegate_id', $request->delegate_id);
            }
            if (! empty($request->from) && ! empty($request->to)) {
                $Reports = $Reports->whereDate('date', '>=', $request->from)
                    ->whereDate('date', '<=', $request->to);

            }

            return new DailyReportCollection(($Reports->paginate(10)));

        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Authentication',
            ], 503);
        }
    }

    public function Client_Delegate()
    {
        $user = auth()->user();
        if ($user) {
            $clients = ClientDelegateResource::collection(Delegate_client::where('client_id', $user->id)->get());
            if (count($clients) > 0) {

                return response()->json([
                    'success' => 1,
                    'clients' => $clients,
                ], 200);
            } else {
                return response()->json([
                    'success' => 1,
                    'clients' => 'لم يتم ربط  هذا العميل بمندوب',

                ], 200);
            }
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid Authentication',
            ], 503);
        }
    }
}
