<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User_package;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    //delegate_appear
    public function __construct()
    {

    }

    public function index(request $request)
    {
        $id = $request->id;
        $Packages = User_package::where('user_id', Auth()->user()->id)->get();

        return view('client.packages.index', compact('Packages', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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
}
