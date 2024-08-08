<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse_branche;
use App\Models\Warehouse_content;
use DB;
use Illuminate\Http\Request;

class warehouse_areasController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:show_branch', ['only'=>'index', 'show']);
        // $this->middleware('permission:add_branch', ['only'=>'create', 'store']);
        // $this->middleware('permission:edit_branch', ['only'=>'edit', 'update']);
        // $this->middleware('permission:delete_branch', ['only'=>'destroy']);
    }

    public function index(request $request)
    {
        $branch = Warehouse_branche::find($request->branch_id);
        if ($branch->company_id != Auth()->user()->company_id) {
            return redirect(url(Auth()->user()->user_type));

        }
        $stands = Warehouse_content::where('warehouse_id', $request->branch_id)->where('type', 'stand')->orderBy('id', 'ASC')->get();
        $floors = Warehouse_content::where('warehouse_id', $request->branch_id)->where('type', 'floor')->orderBy('id', 'ASC')->get();
        $packages = Warehouse_content::where('warehouse_id', $request->branch_id)->where('type', 'package')->orderBy('id', 'ASC')->get();
        $floors = Warehouse_content::where('warehouse_id', $request->branch_id)->where('type', 'floor')->orderBy('id', 'ASC')->get();

        $duplicateRows = DB::table('warehouse_contents')
            ->select('type', DB::raw('COUNT(*) as count'))
            ->where('warehouse_id', $request->branch_id)
            ->where('work',1)
            ->groupBy('floor_id')
            ->having('type', '=', 'package')
            ->get();
        
            $duplicateRows2 = DB::table('warehouse_contents')
            ->select('type', DB::raw('COUNT(*) as count'))
            ->where('warehouse_id', $request->branch_id)
            ->where('work',2)
            ->groupBy('floor_id')
            ->having('type', '=', 'package')
            ->get();
        $package_num = 0;
        $package_num2 = 0;

        foreach ($duplicateRows as $duplicateRow) {
            if ($duplicateRow->count > $package_num) {
                $package_num = $duplicateRow->count;

            }

        }

        foreach ($duplicateRows2 as $duplicateRow) {
            if ($duplicateRow->count > $package_num2) {
                $package_num2 = $duplicateRow->count;

            }

        }

        return view('admin.Warehouse_branches.area', compact('branch', 'package_num', 'stands', 'floors', 'packages','package_num2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function area(Request $request)
    {
        $id = $request->val;
        $data = Warehouse_content::find($id);
        if ($data != null) {
            if ($data->is_busy == 0) {
                $data->is_busy = 1;
            } else {
                $data->is_busy = 0;
            }
            $data->save();

            return $data->is_busy;
        } else {
            return 'error';
        }
    }
}
