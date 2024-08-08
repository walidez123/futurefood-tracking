<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class RegionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_neighborhood', ['only' => 'index', 'show']);
        $this->middleware('permission:add_neighborhood', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_neighborhood', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_neighborhood', ['only' => 'destroy']);
    }

    public function index()
    {
        $regions = Neighborhood::with('city')->paginate(25);

        return view('admin.cities.indexRegion', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $cities = City::get();

        return view('admin.cities.addRegion', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2',
            'title_ar' => 'required|min:2',
            'city_id' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',

        ]);
        Neighborhood::create($request->all());
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('RegionCompany.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $region = Neighborhood::find($id);
            $cities = City::get();

        return view('admin.cities.editRegion', compact('cities', 'region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:2',
            'title_ar' => 'required|min:2',
            'city_id' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',

        ]);
        $Region = Neighborhood::findOrFail($id);

        $Region->update($request->all());
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('RegionCompany.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Region = Neighborhood::findOrFail($id);

        Neighborhood::findOrFail($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    public function city($id)
    {

        $city = City::find($id);
        $regions = Neighborhood::where('city_id', $id)->paginate(25);

        return view('admin.cities.indexRegion', compact('regions', 'city'));

    }

    public function getregions($id, Request $request)
    {

        $regions = Neighborhood::select('id', 'title')->where('city_id', '=', $id)->get();
        $arr = [];
        $arr[0] = "<option value='0'> أختر الحي </option>";

        foreach ($regions as $i => $model) {

            $arr[$i + 1] = "<option value='$model->id'> $model->title </option>";

        }

        return \Response::json($arr);

    }
}
