<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermissions;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:show_role', ['only' => 'index', 'show']);
        // $this->middleware('permission:add_role', ['only' => 'create', 'store']);
        // $this->middleware('permission:edit_role', ['only' => 'edit', 'update']);
        // $this->middleware('permission:delete_role', ['only' => 'destroy']);
    }

    public function index()
    {
        $roles = Role::where('company_id', Auth()->user()->id)->paginate(15);

        return view('client.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.roles.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->only(['title']);
        $data['company_id'] = Auth()->user()->id;

        $role = Role::create($data);
        $permissions = $request['permissions'];
        // dd($permissions);
        foreach ($permissions as $permission) {
            $permission = Permission::where('id', '=', $permission)->firstOrFail();
            $role->permissions()->detach($permission->id);
            $role->permissions()->attach($permission->id);
        }
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('roles.index')->with($notification);
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
    public function edit(Role $role)
    {
        $permissions = RolePermissions::where('role_id', $role->id)->get();
        $arrPermissions = [];
        foreach ($permissions as $permission) {
            $arrPermissions[] = $permission->permission_id;
        }

        return view('client.roles.edit', compact('role', 'arrPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $data = $request->only(['title']);
        $role->update($data);

        $permissions = $request['permissions'];
        $role->permissions()->sync($permissions);
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('roles.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);

    }
}
