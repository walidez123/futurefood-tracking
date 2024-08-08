<?php

namespace App\Http\Controllers\Api\Warehouse_employee;

use App\Http\Controllers\Controller;
use App\Models\Good;
use App\Models\Warehouse_branche;
use App\Models\Client_packages_good;
use Illuminate\Http\Request;
use App\Http\Resources\ClientPackagesGoodResource;
use App\Http\Resources\GoodsResource;
use Validator;


class GoodsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        $user = Auth()->user();

           
        if ($user->user_type == 'admin') {

            $goods = GoodsResource::collection( Good::where('company_id', Auth()->user()->company_id)->paginate(15));

            return response()->json($goods);

        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }    


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       
    }

    public function store(Request $request)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }

    public function goodSearch(request $request)
    {
        $user = Auth()->user();

        if ($user->user_type == 'admin') {

            $rules = [
                'warhouse_id' => 'nullable|numeric|exists:Warehouse_branches,id',
                'goods' => 'nullable|numeric|exists:goods,id',
                'from_date' => 'nullable|date',
                'to_date' => 'nullable|date',

            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->messages(),
                ]);
            }

            $from = $request->get('from_date');
            $to = $request->get('to_date');
            $warehouse_branch = $request->get('warhouse_id');
            $goods = $request->get('goods');
            $packages_goods=Client_packages_good::where('company_id',Auth()->user()->company_id);
            if ($from != null && $to != null) {
                
                $packages_goods = $packages_goods->packages_goods::whereDate('updated_at', '>=', $from)
                    ->whereDate('updated_at', '<=', $to);
            
            }

            if ($warehouse_branch != null) {
                $packages_goods->where('warehouse_id', $warehouse_branch);
            }

            if ($goods != null) {

                $packages_goods = $packages_goods->where('good_id',$goods);
                
            }
            $data = ClientPackagesGoodResource::collection($packages_goods->paginate(15));

            return response()->json($data);
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        } 
    }

    public function clientSearch(request $request)
    {
        $user = Auth()->user();

        if ($user->user_type == 'admin') {
       
            $rules = [
                'client_id' => 'nullable|numeric|exists:users,id',
                'warhouse_id' => 'nullable|numeric|exists:Warehouse_branches,id',
                'from_date' => 'nullable|date',
                'to_date' => 'nullable|date',

            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->messages(),
                ]);
            }
      
            $from = $request->get('from_date');
            $to = $request->get('to_date');
            $client = $request->get('client_id');
            $warehouse_branch = $request->get('warhouse_id');
            $packages_goods = Client_packages_good::where('company_id', Auth()->user()->company_id);
            if ($from != null && $to != null) {
            
                $packages_goods = $packages_goods->whereDate('updated_at', '>=', $from)
                    ->whereDate('updated_at', '<=', $to);
                
            }
            if ($client != null) {
                $packages_goods->where('client_id', $client);
            }
            $data = ClientPackagesGoodResource::collection($packages_goods->paginate(15));

            return response()->json($data);
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        } 

    }
}
