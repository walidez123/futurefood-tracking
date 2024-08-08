<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\User_package;
use Carbon\Carbon;
use Illuminate\Http\Request;

class client_packagesController extends Controller
{
    //delegate_appear
    public function __construct()
    {
        $this->middleware('permission:show_client_packages', ['only' => 'index', 'show']);
        $this->middleware('permission:add_client_packages', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_client_packages', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_client_packages', ['only' => 'destroy']);
    }

    public function index(request $request)
    {
        $id = $request->id;
        $Packages = User_package::where('user_id', $id)->get();

        return view('admin.clients.packages.index', compact('Packages', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {
        $id = $request->id;
        $packages = Package::where('publish', 1)->where('company_id', Auth()->user()->company_id)->get();

        return view('admin.clients.packages.add', compact('id', 'packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title'   => 'required',
        // ]);
        $requestDate = $request->all();
        $date = Carbon::createFromFormat('Y-m-d', $request->start_date);
        $daysToAdd = $request->num_days;
        $daysToAdd=$daysToAdd-1;

        $date = $date->addDays($daysToAdd);
        $requestDate['end_date'] = $date;
        $User_package = User_package::create($requestDate);
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('clinet_packages.index', ['id' => $User_package->user_id])->with($notification);
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

        $User_package = User_package::find($id);

        return view('admin.clients.packages.edit', compact('User_package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'title'   => 'required',
        // ]);
        $User_package = User_package::findOrFail($id);
        $requestDate = $request->all();
        $date = Carbon::createFromFormat('Y-m-d', $request->start_date);
        $daysToAdd = $request->num_days;
        $daysToAdd=$daysToAdd-1;

        $date = $date->addDays($daysToAdd);
        $requestDate['end_date'] = $date;

        $User_package->update($requestDate);
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('clinet_packages.index', ['id' => $User_package->user_id])->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        User_package::findOrFail($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
    public function renewal($id){
        $User_package = User_package::findOrFail($id);
        // $date = Carbon::createFromFormat('Y-m-d', $User_package->end_date);
        $start = (new \Carbon\Carbon())->today();
      $requestDate['start_date'] =  (new \Carbon\Carbon())->today();;


        $daysToAdd = $User_package->num_days;
        $daysToAdd=$daysToAdd-1;
        $date = $start->addDays($daysToAdd);

        $requestDate['end_date'] = $date;

        $User_package->update($requestDate);
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('clinet_packages.index', ['id' => $User_package->user_id])->with($notification);
        
    }
}
