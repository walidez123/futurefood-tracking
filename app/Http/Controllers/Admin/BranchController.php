<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Company_branche;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_branch', ['only' => 'index', 'show']);
        $this->middleware('permission:add_branch', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_branch', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_branch', ['only' => 'destroy']);
    }

    public function index()
    {
        $branches = Company_branche::paginate(25);

        return view('admin.branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

            $cities = City::get();

        return view('admin.branch.add', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'phone' => 'required',
            'city_id' => 'required',
            // 'region_id'      => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);
        $branch = Company_branche::create($request->all());

        if ($branch) {
            $notification = [
                'message' => '<h3>Saved Successfully</h3>',
                'alert-type' => 'success',
            ];
        } else {
            $notification = [
                'message' => '<h3>Something wrong Please Try again later</h3>',
                'alert-type' => 'error',
            ];
        }

        return redirect()->route('Company_branches.index')->with($notification);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $branch = Company_branche::findorfail($id);
        $this->authorize('showBranch', $branch);

        $cities = City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->orderBy('company_id', 'DESC')->paginate(25);
        $region = Neighborhood::where('id', $branch->region_id)->first();

        return view('admin.branch.edit', compact('branch', 'cities', 'region'));
    }

    public function update(Request $request, $id)
    {
        $branch = Company_branche::findOrFail($id);

        if ($branch->update($request->all())) {
            $notification = [
                'message' => '<h3>Saved Successfully</h3>',
                'alert-type' => 'success',
            ];
        } else {
            $notification = [
                'message' => '<h3>Something wrong Please Try again later</h3>',
                'alert-type' => 'error',
            ];
        }

        return redirect()->route('Company_branches.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Company_branche::findOrFail($id);
        $this->authorize('showBranch', $branch);

        if ($branch) {
            $branch->delete();
        }
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
