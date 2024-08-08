<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use App\Http\Resources\GoodsResource;
use App\Models\Good;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodsController extends Controller
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

            return GoodsResource::collection(((Good::where('client_id', $user->id)->paginate(10))));

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Good $goods)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Good $goods)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Good $goods)
    {
        //
    }
}
