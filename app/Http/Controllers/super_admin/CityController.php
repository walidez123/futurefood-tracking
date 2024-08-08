<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:show_city', ['only' => 'index', 'show']);
        // $this->middleware('permission:add_city', ['only' => 'create', 'store']);
        // $this->middleware('permission:edit_city', ['only' => 'edit', 'update']);
        // $this->middleware('permission:delete_city', ['only' => 'destroy']);
    }

    public function index()
    {
        $cities = City::paginate(25);

        return view('super_admin.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Province::get();
        return view('super_admin.cities.add', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'abbreviation' => 'nullable|string|max:255',
                'title' => 'required|string|max:255',
                'title_ar' => 'required|string|max:255',
                'longitude' => 'nullable|string|max:255',
                'latitude' => 'nullable|string|max:255',
                'smb' => 'nullable|boolean',
                'aymakan' => 'nullable|boolean',
                'labiah' => 'nullable|boolean',
                'jandt' => 'nullable|boolean',
                'province_id' => 'nullable',
            ]);
    
            City::create($request->all());
    
            return redirect()->route('cities.index')->with('success', 'City added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while adding the city: ' . $e->getMessage());
        }
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
    public function edit(City $city)
    {
        $provinces = Province::get();

        return view('super_admin.cities.edit', compact('city', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      
        try {
            $validatedData = $request->validate([
                'abbreviation' => 'nullable|string|max:255',
                'title' => 'required|string|max:255',
                'title_ar' => 'required|string|max:255',
                'longitude' => 'nullable|string|max:255',
                'latitude' => 'nullable|string|max:255',
                'smb' => 'nullable|boolean',
                'aymakan' => 'nullable|boolean',
                'labiah' => 'nullable|boolean',
                'jandt' => 'nullable|boolean',
                'province_id' => 'nullable',

            ]);

            $city = City::findOrFail($id);
            $city->update($request->all());

            return redirect()->route('cities.index')->with('success', 'City updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the city: ' . $e->getMessage());
        }
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);

        City::findOrFail($id)->delete();
        Neighborhood::where('city_id', $id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
