<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Neighborhood_zone;
use App\Models\Zone;
use Illuminate\Http\Request;

class RegionZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_RegionZone', ['only' => 'index', 'show']);
        $this->middleware('permission:add_RegionZone', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_RegionZone', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_RegionZone', ['only' => 'destroy']);
    }

    public function index()
    {
        $zones = Zone::where('company_id', Auth()->user()->company_id)->where('type', 'region')->paginate(25);

        return view('admin.zones.indexRegion', compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $cities = City::get();
        $regions = Neighborhood::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->orderBy('company_id', 'DESC')->get();

        return view('admin.zones.addRegion', compact('regions', 'cities'));
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
        if ($request->neighborhood_id != null) {
            foreach ($request->neighborhood_id as $id) {
                $region = Neighborhood::where('id', '=', $id)->firstOrFail();
                $Neighborhood_zone = new Neighborhood_zone();
                $Neighborhood_zone->zone_id = $zone->id;
                $Neighborhood_zone->neighborhood_id = $region->id;
                $Neighborhood_zone->company_id = Auth()->user()->company_id;
                $Neighborhood_zone->save();

            }
        }
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('RegionZone.index')->with($notification);
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
        $neighborhood_zones = Neighborhood_zone::where('company_id', Auth()->user()->company_id)->where('zone_id', '!=', $zone->id)->pluck('neighborhood_id')->toArray();

            $cities = City::get();
        $regions = Neighborhood::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->whereNotIn('id', $neighborhood_zones)->where('city_id', $zone->city_id)->orderBy('company_id', 'DESC')->get();
        $regionZones = Neighborhood_zone::where('zone_id', $id)->get();
        $arrZones = [];
        foreach ($regionZones as $regionZone) {
            $arrZones[] = $regionZone->neighborhood_id;
        }

        return view('admin.zones.editRegion', compact('cities', 'zone', 'regions', 'arrZones'));
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
        $regions = $request['neighborhood_id'];
        // $Zone->regions()->sync($regions);
        if ($request->neighborhood_id != null) {
            Neighborhood_zone::where('zone_id', $Zone->id)->delete();
            foreach ($request->neighborhood_id as $id) {
                $region = Neighborhood::where('id', '=', $id)->firstOrFail();
                $Neighborhood_zone = new Neighborhood_zone();
                $Neighborhood_zone->zone_id = $Zone->id;
                $Neighborhood_zone->neighborhood_id = $region->id;
                $Neighborhood_zone->company_id = Auth()->user()->company_id;
                $Neighborhood_zone->save();

            }
        }

        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('RegionZone.index')->with($notification);
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
        Neighborhood_zone::where('zone_id', $Zone->id)->delete();
        $Zone->delete();

        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
