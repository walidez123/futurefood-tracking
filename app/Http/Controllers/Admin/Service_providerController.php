<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientTransactions;
use App\Models\Role;
use App\Models\User;
use App\Models\User_work;
use App\Models\ServiceProviderCost;
use Illuminate\Http\Request;

class Service_providerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_service_provider', ['only' => 'index', 'show']);
        $this->middleware('permission:add_service_provider', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_service_provider', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_service_provider', ['only' => 'destroy']);
        $this->middleware('permission:show_balance_service_provider', ['only' => 'balances', 'transactions']);

    }

    public function index(Request $request)
    {
        $type = $request->type;
        if ($type == null) {
            $users = User::where('company_id', Auth()->user()->company_id)->orderBy('id','desc')->where('user_type', 'service_provider')->paginate(25);
        } else {

            $users = User::where('company_id', Auth()->user()->company_id)->orderBy('id','desc')->where('user_type', 'service_provider')->whereHas('user_works', function ($query) use ($type) {
                $query->where('work', $type);
            })->orderBy('id', 'desc')->paginate(25);

        }

        return view('admin.service_provider.index', compact('users', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = $request->type;
        $roles = Role::where('company_id', Auth()->user()->company_id)->get();

        return view('admin.service_provider.add', compact('roles', 'type'));
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
            //   'role_id'                           => 'required',
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
            $user_cost = ServiceProviderCost::create([
                'user_id' => $user->id,
                'cost_last_mile' => $request->cost_last_mile,
                'cost_restaurant' => $request->cost_restaurant,
                'cost_fulfillment' => $request->cost_fulfillment,

            ]);
            foreach ($request->works as $work) {

                $Company_work = new User_work();
                $Company_work->user_id = $user->id;
                $Company_work->work = $work;
                $Company_work->save();

            }
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

        return redirect()->route('service_provider.index')->with($notification);
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

        return view('admin.service_provider.show', compact('user'));
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
        $works = User_work::where('user_id', $user->id)->pluck('work')->toArray();


        return view('admin.service_provider.edit', compact('user', 'works'));
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
        $ServiceProviderCost = ServiceProviderCost::where('user_id', $user->id)->first();
        if($ServiceProviderCost==NULL)
        {
            ServiceProviderCost::create([
                'user_id' => $user->id,
                'cost_last_mile' => $request->cost_last_mile,
                'cost_restaurant' => $request->cost_restaurant,
                'cost_fulfillment' => $request->cost_fulfillment,
            ]);

        }else{
            $ServiceProviderCost->update([
                'cost_last_mile' => $request->cost_last_mile,
                'cost_restaurant' => $request->cost_restaurant,
                'cost_fulfillment' => $request->cost_fulfillment,
            ]);

        }

       
        User_work::where('user_id', $user->id)->delete();

        foreach ($request->works as $work) {

            $Company_work = new User_work();
            $Company_work->user_id = $user->id;
            $Company_work->work = $work;
            $Company_work->save();

        }
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('service_provider.index')->with($notification);
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

    public function balances(Request $request)
    {
        $delegates = User::orderBy('id', 'desc')->where('company_id', Auth()->user()->company_id)->where('user_type', 'service_provider')->paginate(15);
        if (! empty($delegates)) {
            foreach ($delegates as $client) {
                $transactions = ClientTransactions::where('user_id', $client->id);
                $client->count_creditor = $transactions->sum('creditor');

                $client->count_debtor = $transactions->sum('debtor');
            }

        }

        return view('admin.service_provider.balances', compact('delegates'));
    }

    public function transactions(Request $request, $id)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $delegate = User::orderBy('id', 'desc')->where('id', $id)->first();
        if ($delegate) {
            $transactions = ClientTransactions::orderBy('id', 'desc')->where('user_id', $id);
            if ($from != null && $to != null) {
                $transactions = $transactions->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to);
            }
            $alltransactions = $transactions->orderBy('id', 'desc')->paginate(50);
            $count_creditor = $transactions->sum('creditor');
            $count_debtor = $transactions->sum('debtor');

            $count_order_creditor = $transactions->whereNotNull('order_id')->sum('creditor');

            $count_order_debtor = $transactions->whereNotNull('order_id')->sum('debtor');

            $transactions = $transactions->paginate(50);

            return view('admin.service_provider.balance-transactions', compact('alltransactions', 'transactions', 'delegate', 'from', 'to', 'count_debtor', 'count_creditor', 'count_order_creditor', 'count_order_debtor'));
        } else {
            abort(404);
        }
    }
}
