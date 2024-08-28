<?php

namespace App\Http\Controllers\Api\Resturant;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressCollection;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->user_type == 'client') {
            return new AddressCollection(($user->addresses()->get()));
        } else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth()->user();

        if ($user->user_type == 'client') {

            $request->validate([
                'city_id' => 'nullable|numeric',
                'neighborhood_id' => 'nullable|numeric',
                'address' => 'required|min:3|max:255',
                'phone' => 'nullable|numeric|min:10|starts_with:05',
                'main_address' => 'nullable|boolean',
                'description' => 'nullable|string',
                'longitude' => 'nullable|string',
                'latitude' => 'nullable|string',
            ]);

            if ($request['main_address'] == 1) {
                Address::where('user_id', $user->id)->update(['main_address' => 0]);
            }

            $address = $request->user()->addresses()->create($request->all());

            return response()->json([
                'message' => 'Saved Successfully',
            ], 200);

        } else {
            return response()->json([
                'message' => 'Invalid Authentication',
            ], 503);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        //
    }
}
