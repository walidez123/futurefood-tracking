<?php

namespace App\Http\Controllers\Api\Warehouse_employee;

use App\Http\Controllers\Controller;
use App\Models\Warehouse_branche;
use Illuminate\Http\Request;
use App\Http\Resources\WarehouseBrancheResource;
use App\Models\Warehouse_content;
use App\Http\Resources\WarehousePackageResource;

class WarehouseBranchesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        $user = Auth()->user();

           
        if ($user->user_type == 'admin') {

            $branches = WarehouseBrancheResource::collection( Warehouse_branche::where('company_id', Auth()->user()->company_id)->paginate(15));

            return response()->json($branches);

        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }    


    }


    // 
    public function fuliflment()
    {
        $user = Auth()->user();

        if ($user->user_type == 'admin') {

            $branches = WarehouseBrancheResource::collection( Warehouse_branche::whereIn('work', [2, 3])->where('company_id', Auth()->user()->company_id)->get());


            return response()->json($branches);

        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }    


    }

    public function warehouse_packages(request $request)
    {
        $user = Auth()->user();

        if ($user->user_type == 'admin') {
            $Warehouse=Warehouse_branche::findOrFail($request->warehouse_id);
            if($Warehouse)
            {

            $branches = WarehousePackageResource::collection( Warehouse_content::where('warehouse_id', $Warehouse->id)->where('type', 'package')->orderBy('id', 'desc')->get());
            return response()->json($branches);

            }else{
                return response()->json([
                    'success' => 0,
                    'message' => __('api_massage.not fount'),
                ], 503);

            }



        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.Invalid Authentication'),
            ], 503);
        }    


    }

    // 
    public function warehouse()
    {
        $user = Auth()->user();

           
        if ($user->user_type == 'admin') {

            $branches = WarehouseBrancheResource::collection( Warehouse_branche::whereIn('work', [1, 3])->where('company_id', Auth()->user()->company_id)->get());

            return response()->json($branches);

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
}
