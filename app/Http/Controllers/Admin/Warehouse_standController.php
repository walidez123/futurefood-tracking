<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse_branche;
use App\Models\Warehouse_content;
use Illuminate\Http\Request;

class Warehouse_standController extends Controller
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

        $branch = Warehouse_branche::find($request->id);

        if ($branch->company_id != Auth()->user()->company_id) {
            return redirect(url(Auth()->user()->user_type));

        }

        $warehouse_stand = $request->id;
        $type = $request->type;
        if ($type == 'warehouses') {
            $stands = Warehouse_content::where('Warehouse_id', $request->id)->where('work', 1)->where('type', 'stand')->paginate(25);
        } elseif ($type == 'fulfillment') {
            $stands = Warehouse_content::where('Warehouse_id', $request->id)->where('work', 2)->where('type', 'stand')->paginate(25);

        }

        return view('admin.Warehouse_branches.stands.index', compact('stands', 'warehouse_stand', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->type == 'warehouses') {
            $work = 1;
        } elseif ($request->type == 'fulfillment') {
            $work = 2;
        }
        $lastpackage = Warehouse_content::where('warehouse_id', $request->warehouse_id)->where('type', 'stand')->orderBy('id', 'DESC')->first();
        $value = str_split($lastpackage->title);
        $title = substr($lastpackage->title, 0, -1);
        for ($j = 1; $j <= $request->number; $j++) {
            $package = new Warehouse_content();
            $package->warehouse_id = $lastpackage->warehouse_id;
            $package->title = $title.last($value) + $j;
            $package->type = 'stand';
            $package->work = $work;

            $package->save();
        }

        return redirect()->route('warehouse_stand.index', ['id' => $lastpackage->warehouse_id, 'type' => $request->type]);
    }
    // packages

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Warehouse_content::findOrFail($id);
        $content = Warehouse_content::where('stand_id', $id)->delete();
        if ($branch) {
            $branch->delete();
        }
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
