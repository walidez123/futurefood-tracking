<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\City_zone;
use App\Models\Zone;
use Illuminate\Http\Request;

class CityZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_CityZone', ['only' => 'index', 'show']);
        $this->middleware('permission:add_CityZone', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_CityZone', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_CityZone', ['only' => 'destroy']);
    }

    public function index()
    {
        $zones = Zone::where('company_id', Auth()->user()->company_id)->where('type', 'city')->paginate(25);

        return view('admin.zones.index', compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $cities = City::where('company_id',Auth()->user()->company_id)->orWhere('company_id',NULL)->orderBy('company_id',"DESC")->get();
        $city_Zone = City_zone::where('company_id', Auth()->user()->company_id)->pluck('city_id')->toArray();
        $cities = City::Where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->whereNotIn('id', $city_Zone)->orderBy('company_id', 'DESC')->get();

        return view('admin.zones.add', compact('cities', 'city_Zone'));
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
            'title_ar' => 'required',

        ]);
        $zone = Zone::create($request->all());
        if ($request->city != null) {
            foreach ($request->city as $id) {

                $city = City::where('id', '=', $id)->firstOrFail();
                // $zone->cites()->detach($city->id);
                // $zone->cites()->attach($city->id);
                $city_zone = new City_zone();
                $city_zone->zone_id = $zone->id;
                $city_zone->city_id = $city->id;
                $city_zone->company_id = Auth()->user()->company_id;
                $city_zone->save();
            }
        }
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('CityZone.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $zone = Zone::find($id);
        $citesZones = City_zone::where('zone_id', $id)->get();
        $arrZones = [];
        foreach ($citesZones as $citesZone) {
            $arrZones[] = $citesZone->city_id;
        }

        //
        $Allcity_Zone = City_zone::where('company_id', Auth()->user()->company_id)->where('zone_id', '!=', $zone->id)->pluck('city_id')->toArray();

        $cities = City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->whereNotIn('id', $Allcity_Zone)->orderBy('company_id', 'DESC')->get();

        return view('admin.zones.edit', compact('cities', 'zone', 'arrZones'));
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
            'title_ar' => 'required',

        ]);
        $Zone = Zone::findOrFail($id);
        $Zone->update($request->all());
        $cities = $request['city'];
        // $Zone->cites()->sync($cities);
        if ($request->city != null) {
            City_zone::where('zone_id', $Zone->id)->delete();

            foreach ($request->city as $id) {

                $city = City::where('id', '=', $id)->firstOrFail();
                // $Zone->cites()->detach($city->id);
                // $zone->cites()->attach($city->id);
                $city_zone = new City_zone();
                $city_zone->zone_id = $Zone->id;
                $city_zone->city_id = $city->id;
                $city_zone->company_id = Auth()->user()->company_id;
                $city_zone->save();
            }
        }

        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('CityZone.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Zone = Zone::findOrFail($id);
        City_zone::where('zone_id', $Zone->id)->delete();
        $Zone->delete();

        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
