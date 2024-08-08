<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company_setting;
use App\Models\Warehouse_branche;
use App\Models\Warehouse_content;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class warehouse_packageController extends Controller
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
        if ($stand_id != null) {
            $branch = Warehouse_branche::find($stand_id->warehouse_id);
            if ($branch->company_id != Auth()->user()->company_id) {
                return redirect(url(Auth()->user()->user_type));
            }
        }
        $stands = Warehouse_content::where('floor_id', $request->id)->where('type', 'package')->paginate(25);

        return view('admin.Warehouse_branches.stands.floors.packages.index', compact('stands', 'stand_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $setting = Company_setting::where('company_id', Auth()->user()->company_id)->first();
        $floor = Warehouse_content::find($request->floor_id);
        $lastpackage = Warehouse_content::where('floor_id', $request->floor_id)->where('type', 'package')->orderBy('id', 'DESC')->first();
        if ($lastpackage != null) {

            $value = str_split($lastpackage->title);
            $title = substr($lastpackage->title, 0, -1);

            for ($j = 1; $j <= $request->number; $j++) {
                $package = new Warehouse_content();
                $package->warehouse_id = $lastpackage->warehouse_id;
                $package->title = $title.last($value) + $j;
                $package->type = 'package';
                $package->stand_id = $lastpackage->stand_id;
                $package->floor_id = $lastpackage->floor_id;
                $package->work = $floor->work;
                $package->save();
            }
        } else {

            $lastpackage = Warehouse_content::where('id', $request->floor_id)->first();

            $title = Str::remove($setting->floor_number_characters, $lastpackage->title);
            for ($j = 1; $j <= $request->number; $j++) {
                $package = new Warehouse_content();
                $package->warehouse_id = $lastpackage->warehouse_id;
                $package->title = $setting->shelves_number_characters.$title.$j;
                $package->type = 'package';
                $package->stand_id = $lastpackage->stand_id;
                $package->floor_id = $lastpackage->id;
                $package->work = $floor->work;

                $package->save();
            }

        }

        return redirect()->route('warehouse_package.index', ['id' => $package->floor_id]);
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
