<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::where('user_id', Auth()->user()->id)->get();

        return view('client.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->get();

        return view('client.addresses.add', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'city_id' => 'nullable|numeric',
            'address' => 'required|min:3|max:255',
            'phone' => 'nullable|numeric|min:10|starts_with:05',
        ]);

        $user = Auth()->user();
        //
        if ($request['main_address'] == 1) {
            Address::where('user_id', $user->id)->update(['main_address' => 0]);
        }
        //

        $request->user()->addresses()->create($request->all());

        return redirect()->route('addresses.index')->with('success', 'Address created successfully');
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
    public function edit(Address $address)
    {
        $cities = City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->get();
        $region = Neighborhood::where('id', $address->neighborhood_id)->first();

        return view('client.addresses.edit', compact('cities', 'address', 'region'));
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
            'city_id' => 'required|numeric',
            'address' => 'min:3|max:100',
            'phone' => 'nullable|numeric|min:10|starts_with:05',
        ]);

        $address = Address::findOrFail($id);
        //
        if ($request['main_address'] == 1) {
            Address::where('user_id', Auth()->user()->id)->update(['main_address' => 0]);
        }
        //
        if ($request->map_or_link == 'link') {
            $address->update($request->all());
            $address->update([

                'longitude' => null,
                'latitude' => null,
            ]);
            // dd($address);
        } elseif ($request->map_or_link == 'map') {
            $address->update($request->all());
            $address->update(['link' => null]);
        }

        return redirect()->route('addresses.index')->with('success', 'Address updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Address::findOrFail($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
