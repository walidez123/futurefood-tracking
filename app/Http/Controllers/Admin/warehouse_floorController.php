<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company_setting;
use App\Models\Warehouse_branche;
use App\Models\Warehouse_content;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class warehouse_floorController extends Controller
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
        $stand_id = Warehouse_content::where('id', $request->id)->first();
        $branch = Warehouse_branche::where('id', $stand_id->warehouse_id)->first();

        if ($branch->company_id != Auth()->user()->company_id) {
            return redirect(url(Auth()->user()->user_type));

        }
        $stands = Warehouse_content::where('stand_id', $request->id)->where('type', 'floor')->paginate(25);
        $stand_id = $request->id;

        return view('admin.Warehouse_branches.stands.floors.index', compact('stands', 'stand_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stand = Warehouse_content::find($request->stand_id);
        $lastpackage = Warehouse_content::where('stand_id', $request->stand_id)->where('type', 'floor')->orderBy('id', 'DESC')->first();
        if ($lastpackage != null) {
            $value = str_split($lastpackage->title);
            $title = substr($lastpackage->title, 0, -1);
            for ($j = 1; $j <= $request->number; $j++) {
                $package = new Warehouse_content();
                $package->warehouse_id = $lastpackage->warehouse_id;
                $package->title = $title.last($value) + $j;
                $package->type = 'floor';
                $package->stand_id = $request->stand_id;
                $package->work = $stand->work;

                $package->save();
            }

        } else {
            $setting = Company_setting::where('company_id', Auth()->user()->company_id)->first();
            $lastpackage = Warehouse_content::find($request->stand_id);
            $title = Str::remove($setting->stand_number_characters, $lastpackage->title);

            for ($j = 1; $j <= $request->number; $j++) {
                $package = new Warehouse_content();
                $package->warehouse_id = $lastpackage->warehouse_id;
                $package->title = $setting->floor_number_characters.$title.$j;
                $package->type = 'floor';
                $package->stand_id = $request->stand_id;
                $package->save();
            }

        }

        return redirect()->route('warehouse_floor.index', ['id' => $package->stand_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Warehouse_content::findOrFail($id);
        $content = Warehouse_content::where('floor_id', $id)->delete();

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
