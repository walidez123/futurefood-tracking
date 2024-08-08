<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\ClientTransactions;
use App\Models\Role;
use App\Models\User;
use App\Models\User_work;
use App\Models\ServiceProviderCost;
use App\Models\CompanyServiceProvider;
use Illuminate\Http\Request;

class Service_providerController extends Controller
{
    public function __construct()
    {
     

    }

    public function index()
    {
       
        $users = User::where('company_id', null)->orderBy('id','desc')->where('user_type', 'service_provider')->paginate(25);
       

        return view('super_admin.service_provider.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        return view('super_admin.service_provider.add');
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
        $userData['company_id'] = null;

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

        return view('super_admin.service_provider.show', compact('user'));
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


        return view('super_admin.service_provider.edit', compact('user', 'works'));
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

        return view('super_admin.service_provider.balances', compact('delegates'));
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

            return view('super_admin.service_provider.balance-transactions', compact('alltransactions', 'transactions', 'delegate', 'from', 'to', 'count_debtor', 'count_creditor', 'count_order_creditor', 'count_order_debtor'));
        } else {
            abort(404);
        }
    }
    public function companyServiceProvider($id)
    {
    
        $service_providers = User::where('company_id', null)->orderBy('id','desc')->where('user_type', 'service_provider')->paginate(25);

        $company = User::where('id', $id)->where('user_type', 'admin')->first();

        // $service_providers = CompanyServiceProvider::where('company_id', $id)->paginate(25);
        

        return view('super_admin.service_provider.activate', compact('service_providers', 'company'));
    }

    public function updateCompanyServiceProviders(Request $request)
    {
        $id = $request->id;
        $data = CompanyServiceProvider::where('company_id', $id);
        if ($data->company_id != Auth()->user()->company_id) {
            return redirect()->back()->with('error', 'غير موجود');
        }
        if ($data != null) {
            if ($data->is_active == 0) {
                $data->is_active = 1;
            } else {
                $data->is_active = 0;
            }
            $data->save();

            return $data->is_active;
        } else {
            return 'error';
        }

    }
    public function activateServiceProvider(Request $request)
    {
        $company_id = $request->input('company_id');

        $service_provider_id = $request->input('service_provider_id');
    
        $companyServiceProvider = CompanyServiceProvider::updateOrCreate(
            ['company_id' => $company_id, 'service_provider_id' => $service_provider_id],
            ['is_active' => true]
        );
    
        return response()->json(['message' => 'Service provider activated successfully']);
    }
    
    public function deactivateServiceProvider(Request $request)
    {
        $company_id = $request->input('company_id');
        $service_provider_id = $request->input('service_provider_id');
    
        $companyServiceProvider = CompanyServiceProvider::updateOrCreate(
            ['company_id' => $company_id, 'service_provider_id' => $service_provider_id],
            ['is_active' => false]
        );
    
        return response()->json(['message' => 'Service provider deactivated successfully']);
    }
    // saveAuthtoken

    public function saveAuthToken(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'auth_token' => 'required|string',
        ]);



        $provider=CompanyServiceProvider::where('service_provider_id',$id)->first();
        $provider->auth_token=$request->auth_token;
        $provider->save();
        return response()->json(['message' => 'Service provider deactivated successfully']);


        // Redirect back with a success message
    }
    
}
