<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class NeighborhoodController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:show_neighborhood', ['only' => 'index', 'show']);
        // $this->middleware('permission:add_neighborhood', ['only' => 'create', 'store']);
        // $this->middleware('permission:edit_neighborhood', ['only' => 'edit', 'update']);
        // $this->middleware('permission:delete_neighborhood', ['only' => 'destroy']);
    }

    public function index()
    {
        $neighborhoods = Neighborhood::with('city')->paginate(25);

        return view('super_admin.cities.index_neighborhood', compact('neighborhoods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::get();

        return view('super_admin.cities.add_neighborhood', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'city_id' => 'required',

        ]);
        Neighborhood::create($request->all());
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('cities.index')->with($notification);
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
    public function edit(Neighborhood $neighborhood)
    {

        $cities = City::get();

        return view('super_admin.cities.edit_neighborhood', compact('cities', 'neighborhood'));
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
            'title' => 'required',
            'city_id' => 'required',

        ]);
        $Neighborhood = Neighborhood::findOrFail($id);

        $Neighborhood->update($request->all());
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('neighborhoods.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

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
        $neighborhoods = Neighborhood::where('city_id', $id)->get();

        return view('super_admin.cities.index_neighborhood', compact('neighborhoods', 'city'));

    }

    public function getneighborhoods($id, Request $request)
    {

        $Neighborhoods = Neighborhood::select('id', 'title')->where('city_id', '=', $id)->get();
        $arr = [];
        $arr[0] = "<option value='0'> أختر الحي </option>";

        foreach ($Neighborhoods as $i => $model) {

            $arr[$i + 1] = "<option value='$model->id'> $model->title </option>";

        }

        return \Response::json($arr);

    }
}
