<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:show_employee', ['only' => 'index', 'show']);
        // $this->middleware('permission:add_employee', ['only' => 'create', 'store']);
        // $this->middleware('permission:edit_employee', ['only' => 'edit', 'update']);
        // $this->middleware('permission:delete_employee', ['only' => 'destroy']);
    }

    public function index(Request $request)
    {
      
        $employees = User::where('company_id', 515)->where('user_type', 'employee')->paginate(25);

        return view('client.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $roles = Role::where('company_id', Auth()->user()->id)->get();

        return view('client.employees.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:8|confirmed',
        ]);

        $userData = $request->all();
        $userData['password'] = bcrypt($request->password);
        $userData['company_id'] = Auth()->user()->id;

        if ($request->hasFile('avatar')) {
            $avatar = 'avatar/'.$request->user_type.'/'.$request->file('avatar')->hashName();
            $uploaded = $request->file('avatar')->storeAs('public', $avatar);
            if ($uploaded) {
                $userData['avatar'] = $avatar;
            }

        }
        $user = User::create($userData);

        if ($user) {
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

        return redirect()->route('employees.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('client.employees.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::get();

        return view('client.employees.edit', compact('user', 'roles'));
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
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'phone' => 'required|unique:users,phone,'.$id,
        ]);
        $userData = $request->all();

        $user = User::findOrFail($id);
        if ($request->password) {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);
            $userData['password'] = bcrypt($request->password);
        } else {
            $userData = $request->except(['password']);
        }
        if ($request->hasFile('avatar')) {
            $avatar = 'avatar/'.$user->user_type.'/'.$request->file('avatar')->hashName();
            $uploaded = $request->file('avatar')->storeAs('public', $avatar);
            if ($uploaded) {
                $userData['avatar'] = $avatar;
            }
        }
        $user->update($userData);

        return redirect()->route('employees.index')->with('success', trans('admin_message.Saved Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    
}
