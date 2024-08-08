<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_Vehicle', ['only' => 'index', 'show']);
        $this->middleware('permission:add_Vehicle', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_Vehicle', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_Vehicle', ['only' => 'destroy']);
    }

    public function index()
    {
        $vehicles = Vehicle::where('company_id', Auth()->user()->company_id)->orderBy('company_id', 'DESC')->paginate(25);

        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vehicles.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'type_ar'   => 'required',
            'type_en' => 'required',
            'vehicle_number_en' => 'required|unique:vehicles,vehicle_number_en',
            // 'vehicle_number_ar'   => 'required|unique:vehicles,vehicle_number_ar',
            'image' => 'mimes:jpeg,jpg,png',

        ]);
        $vehicleData = $request->all();
        if ($request->hasFile('image')) {
            $image = 'avatar/vehicle/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $vehicleData['image'] = $image;
            }
        }
        Vehicle::create($vehicleData);
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('vehicles.index')->with($notification);
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
        $Vehicle = Vehicle::find($id);

        return view('admin.vehicles.edit', compact('Vehicle'));
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
            // 'type_ar'   => 'required',
            'type_en' => 'required',
            'vehicle_number_en' => 'required|unique:vehicles,vehicle_number_en,'.$id,
            // 'vehicle_number_ar'     => 'required|unique:vehicles,vehicle_number_ar,' . $id,
            // 'image'      => 'mimes:JPEG,JPG,PNG,','png','jpg','jpeg',

        ]);
        $Vehicle = Vehicle::findOrFail($id);

        $vehicleData = $request->all();
        if ($request->hasFile('image')) {

            Storage::delete('public/'.$Vehicle->image);
            $image = 'avatar/vehicle/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $vehicleData['image'] = $image;
            }
        }

        $Vehicle->update($vehicleData);
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('vehicles.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Vehicle = Vehicle::findOrFail($id);
        Storage::delete('public/'.$Vehicle->image);
        Vehicle::findOrFail($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
