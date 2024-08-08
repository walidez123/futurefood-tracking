<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Company_setting;
use App\Models\Warehouse_branche;
use App\Models\Warehouse_content;
use App\Models\Client_packages_good;
use Illuminate\Http\Request;

class Warehouse_branchesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_warehouse_branches', ['only' => 'index', 'show']);
        $this->middleware('permission:add_warehouse_branches', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_warehouse_branches', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_warehouse_branches', ['only' => 'destroy']);
    }

    public function index()
    {
        $branches = Warehouse_branche::where('company_id', Auth()->user()->company_id)->paginate(25);

        return view('admin.Warehouse_branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $cities = City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->get();

        return view('admin.Warehouse_branches.add', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'city_id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'area' => 'required',
            'work' => 'required',

        ]);
        if ($request->work == 1 || $request->work == 3) {
            $request->validate([
                'stands' => 'required',
                'floors' => 'required',
                'packages' => 'required',
            ]);

        } elseif ($request->work == 2 || $request->work == 3) {
            $request->validate([
                'fulfillment_stands' => 'required',
                'fulfillment_floors' => 'required',
                'fulfillment_packages' => 'required',
            ]);

        }
        $setting = Company_setting::where('company_id', Auth()->user()->company_id)->first();

        $branch = Warehouse_branche::create($request->all());
        if ($request->work == 1 || $request->work == 3) {
            if ($request->stands) {
                for ($i = 1; $i <= $request->stands; $i++) {

                    $stand = new Warehouse_content();
                    $stand->warehouse_id = $branch->id;
                    $stand->title = $setting->stand_number_characters.'0'.$i;
                    $stand->type = 'stand';
                    $stand->work = '1';

                    $stand->save();

                    for ($k = 1; $k <= $request->floors; $k++) {
                        $floor = new Warehouse_content();
                        $floor->warehouse_id = $branch->id;
                        $floor->title = $setting->floor_number_characters.$i.$k;
                        $floor->type = 'floor';
                        $floor->stand_id = $stand->id;
                        $floor->work = '1';

                        $floor->save();

                        for ($j = 1; $j <= $request->packages; $j++) {
                            $package = new Warehouse_content();
                            $package->warehouse_id = $branch->id;
                            $package->title = $setting->package_number_characters.$i.$k.$j;
                            $package->type = 'package';
                            $package->stand_id = $stand->id;
                            $package->floor_id = $floor->id;
                            $package->work = '1';

                            $package->save();
                        }
                    }
                }
            }
        }
        // fulfillment
        if ($request->work == 2 || $request->work == 3) {
            if ($request->fulfillment_stands) {
                for ($i = 1; $i <= $request->fulfillment_stands; $i++) {

                    $stand = new Warehouse_content();
                    $stand->warehouse_id = $branch->id;
                    $stand->title = $setting->stand_number_characters.'0'.$i;
                    $stand->type = 'stand';
                    $stand->work = 2;
                    $stand->save();

                    for ($k = 1; $k <= $request->fulfillment_floors; $k++) {
                        $floor = new Warehouse_content();
                        $floor->warehouse_id = $branch->id;
                        $floor->title = $setting->floor_number_characters.$i.$k;
                        $floor->type = 'floor';
                        $floor->stand_id = $stand->id;
                        $floor->work = 2;

                        $floor->save();

                        for ($j = 1; $j <= $request->fulfillment_packages; $j++) {
                            $package = new Warehouse_content();
                            $package->warehouse_id = $branch->id;
                            $package->title = $setting->shelves_number_characters.$i.$k.$j;
                            $package->type = 'package';
                            $package->stand_id = $stand->id;
                            $package->floor_id = $floor->id;
                            $package->work = 2;

                            $package->save();
                        }
                    }
                }
            }
        }
        // packages

        if ($branch) {
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

        return redirect()->route('warehouse_branches.index')->with($notification);
    }

    public function edit($id)
    {
        $branch = Warehouse_branche::findorfail($id);
        $cities = City::get();

        return view('admin.Warehouse_branches.edit', compact('branch', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $branch = Warehouse_branche::findOrFail($id);

        if ($branch->update($request->all())) {
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

        return redirect()->route('warehouse_branches.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Warehouse_branche::findOrFail($id);
        Warehouse_content::where('warehouse_id', $id)->delete();
        if ($branch) {
            $branch->delete();
        }
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    public function search(request $request){

        $warehouse_branchs=Warehouse_branche::where('company_id',Auth()->user()->company_id)->get();

        if($request->package_title!=NULL || $request->warhouse_id!=NULL)
        {
            $package_title=$request->package_title;
            $warehouse_branch=$request->warhouse_id;

            
            $warehouseContents=Warehouse_content::where('type','package')
            ->whereHas('warehouse', function ($query) {
                $query->where('company_id', Auth()->user()->company_id);
            });

            if($request->package_title!=NULL)
            {
                $warehouseContents=$warehouseContents->where('title',$request->package_title );
            }if($request->warhouse_id !=null){
                $warehouseContents=$warehouseContents->where('warehouse_id',$request->warhouse_id );

                
            }
            $warehouseContents=$warehouseContents->orderBy('id','desc')->paginate(25);
            return view('admin.Warehouse_branches.search',compact('warehouseContents','package_title','warehouse_branchs','warehouse_branch'));

        }



        return view('admin.Warehouse_branches.search',compact('warehouse_branchs'));
    }

    public function search_details(request $request)
    {

        $package=Warehouse_content::findOrFail(($request->id));
        $packages_goods=Client_packages_good::where('company_id',Auth()->user()->company_id)->where('packages_id',$package->id)->paginate(25);
        return view('admin.Warehouse_branches.search_details',compact('packages_goods'));


    }
}
