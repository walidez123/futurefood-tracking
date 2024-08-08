<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_user', ['only' => 'index', 'show']);
        $this->middleware('permission:add_user', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_user', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_user', ['only' => 'destroy']);
    }

    public function index(request $request)
    {
        if($request->role_id!=NULL)
        {
            $users = User::where('company_id', Auth()->user()->company_id)->where('role_id',$request->role_id)->where('is_company', 0)->where('user_type', 'admin')
            ->whereNotIn('id', [1])
            ->orderBy('id','desc')->paginate(25);

        }else{
            $users = User::where('company_id', Auth()->user()->company_id)->where('is_company', 0)->where('user_type', 'admin')
            ->whereNotIn('id', [1])
            ->orderBy('id','desc')->paginate(25);

        }
       
            $roles = Role::where('company_id', Auth()->user()->company_id)->get();


        return view('admin.users.index', compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Role::where('company_id', Auth()->user()->company_id)->get();

        return view('admin.users.add', compact('roles'));
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
            'role_id' => 'required',
        ]);

        $userData = $request->all();

        $userData['password'] = bcrypt($request->password);
        $userData['company_id'] = Auth()->user()->company_id;

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

        return redirect()->route('users.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::where('company_id', Auth()->user()->company_id)->get();

        return view('admin.users.edit', compact('user', 'roles'));
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

            'role_id' => 'required',
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
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('users.index')->with($notification);
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
