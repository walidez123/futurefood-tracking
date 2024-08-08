<?php

namespace App\Http\Controllers\service_provider;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\ClientTransactions;
use App\Models\Delegate_client;
use App\Models\Delegate_Manger;
use App\Models\Neighborhood;
use App\Models\Status;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DelegateController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:show_delegate', ['only'=>'index', 'show']);
        // $this->middleware('permission:add_delegate', ['only'=>'create', 'store']);
        // $this->middleware('permission:edit_delegate', ['only'=>'edit', 'update']);
        // $this->middleware('permission:delete_delegate', ['only'=>'destroy']);
        // $this->middleware('permission:show_balances', ['only'=>'balances', 'transactions']);
        // $this->middleware('permission:show_follow', ['only'=>'tracking']);
        // $this->middleware('permission:edit_balances', ['only'=>'edit', 'update']);
        // $this->middleware('permission:delete_balances', ['only'=>'transactionDestroy',]);
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $type = $request->type;
        $delegates = User::where('user_type', 'delegate')->where('service_provider', $user->id)->where('work', $request->type)->orderBy('id', 'desc')->paginate(25);

        return view('service_provider.delegates.index', compact('delegates', 'type'));
    }

    public function tracking()
    {
        $delegates = User::where('user_type', 'delegate')->orderBy('id', 'desc')->get();

        return view('service_provider.delegates.tracking', compact('delegates'));
    }

    public function orders($id)
    {
        $delegate = User::findOrFail($id);
        $orders = $delegate->ordersDelegate()->orderBy('id', 'desc')->get();

        return view('service_provider.delegates.orders', compact('orders'));
    }

    public function create(Request $request)
    {
        //
        $code = codegenerateDelegate();
        $type = $request->type;
        $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->where('work', $type)->orderBy('id', 'desc')->get();
        $supervisors = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'supervisor')->orderBy('id', 'desc')->get();
        $service_providers = Auth()->user();
            $cities = City::get();
        $Vehicles = Vehicle::where('service_provider_id', Auth()->user()->id)->orderBy('id', 'desc')->get();

        return view('service_provider.delegates.add', compact('cities', 'type', 'clients', 'supervisors', 'service_providers', 'Vehicles', 'code'));
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
            'code' => 'required|max:3|unique:users,code',
            'email' => 'email|unique:users',
            'phone' => 'required|max:10|starts_with:05|unique:users,phone',
            'Residency_number' => 'required|max:10',
            'password' => 'required|min:8|confirmed',
            'city_id' => 'required',
            'avatar' => 'mimes:jpeg,png,jpg',
            'residence_photo' => 'mimes:jpeg,png,jpg',
            'license_photo' => 'mimes:jpeg,png,jpg',
        ]);

        $delegateData = $request->all();
        $delegateData['password'] = bcrypt($request->password);
        $delegateData['company_id'] = Auth()->user()->company_id;
        $delegateData['is_active'] = 0;

        if ($request->hasFile('avatar')) {
            $avatar = 'avatar/'.$request->user_type.'/'.$request->file('avatar')->hashName();
            $uploaded = $request->file('avatar')->storeAs('public', $avatar);
            if ($uploaded) {
                $delegateData['avatar'] = $avatar;
            }

        }

        if ($request->hasFile('license_photo')) {
            $license_photo = 'avatar/'.$request->user_type.'/'.$request->file('license_photo')->hashName();
            $uploaded = $request->file('license_photo')->storeAs('public', $license_photo);
            if ($uploaded) {
                $delegateData['license_photo'] = $license_photo;
            }

        } if ($request->hasFile('residence_photo')) {
            $residence_photo = 'avatar/'.$request->user_type.'/'.$request->file('residence_photo')->hashName();
            $uploaded = $request->file('residence_photo')->storeAs('public', $residence_photo);
            if ($uploaded) {
                $delegateData['residence_photo'] = $residence_photo;
            }

        }
        $delegate = User::create($delegateData);
        if ($request->client) {
            foreach ($request->client as $client_id) {
                $Delegate_client = new Delegate_client();
                $Delegate_client->client_id = $client_id;
                $Delegate_client->delegate_id = $delegate->id;
                $Delegate_client->save();
            }
        }
        if ($request->manger_name) {
            foreach ($request->manger_name as $manger_id) {
                $Delegate_Manger = new Delegate_Manger();
                $Delegate_Manger->manger_id = $manger_id;
                $Delegate_Manger->delegate_id = $delegate->id;
                $Delegate_Manger->save();
            }
        }

        if ($delegate) {
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

        return redirect()->route('s_p_delegates.index', ['type' => $delegate->work])->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delegate = User::find($id);
        // $this->authorize('showDelegateServiceProvider', $delegate);

        $supervisor = $delegate->Supervisors->pluck('manger_id')->toArray();
        $supervisors = User::whereIn('id', $supervisor)->get();
        $statuses = Status::where('company_id', Auth()->user()->company_id)->orderBy('sort', 'ASC')->get();
        $Delegate_clients = Delegate_client::where('delegate_id', $delegate->id)->get();

        return view('service_provider.delegates.show', compact('delegate', 'statuses', 'supervisors', 'Delegate_clients'));
    }

    public function edit($id)
    {
        $delegate = User::find($id);
        // $this->authorize('showDelegateServiceProvider', $delegate);

        $cities = City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->get();
        $region = Neighborhood::where('id', $delegate->region_id)->first();
        $Delegate_client = Delegate_client::where('delegate_id', $delegate->id)->pluck('client_id')->toArray();
        $clients = User::where('user_type', 'client')->where('work', $delegate->work)->orderBy('id', 'desc')->get();
        $supervisors = User::where('user_type', 'supervisor')->orderBy('id', 'desc')->get();
        $service_providers = User::where('user_type', 'service_provider')->orderBy('id', 'desc')->get();
        $Vehicles = Vehicle::where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->get();
        $Delegate_Mangers = Delegate_Manger::where('delegate_id', $delegate->id)->pluck('manger_id')->toArray();

        return view('service_provider.delegates.edit', compact('Delegate_Mangers', 'delegate', 'cities', 'region', 'clients', 'Delegate_client', 'service_providers', 'supervisors', 'Vehicles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'phone' => 'required|unique:users,phone,'.$id,

            'city_id' => 'required',
        ]);
        $delegateData = $request->all();

        $delegate = User::findOrFail($id);
        if ($request->password) {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);
            $delegateData['password'] = bcrypt($request->password);
        } else {
            $delegateData = $request->except(['password']);
        }
        if ($request->hasFile('avatar')) {
            $avatar = 'avatar/'.$delegate->user_type.'/'.$request->file('avatar')->hashName();
            $uploaded = $request->file('avatar')->storeAs('public', $avatar);
            if ($uploaded) {
                $delegateData['avatar'] = $avatar;
            }

        }
        if ($request->hasFile('vehicle_photo')) {
            $vehicle_photo = 'avatar/'.$request->user_type.'/'.$request->file('vehicle_photo')->hashName();
            $uploaded = $request->file('vehicle_photo')->storeAs('public', $vehicle_photo);
            if ($uploaded) {
                $delegateData['vehicle_photo'] = $vehicle_photo;
            }

        } if ($request->hasFile('license_photo')) {
            $license_photo = 'avatar/'.$request->user_type.'/'.$request->file('license_photo')->hashName();
            $uploaded = $request->file('license_photo')->storeAs('public', $license_photo);
            if ($uploaded) {
                $delegateData['license_photo'] = $license_photo;
            }

        } if ($request->hasFile('residence_photo')) {
            $residence_photo = 'avatar/'.$request->user_type.'/'.$request->file('residence_photo')->hashName();
            $uploaded = $request->file('residence_photo')->storeAs('public', $residence_photo);
            if ($uploaded) {
                $delegateData['residence_photo'] = $residence_photo;
            }

        }
        $delegate->update($delegateData);
        if ($request->client) {
            foreach ($request->client as $client_id) {
                $old = Delegate_client::where('delegate_id', $delegate->id)->where('client_id', $client_id)->first();
                if ($old == null) {
                    $Delegate_client = new Delegate_client();
                    $Delegate_client->client_id = $client_id;
                    $Delegate_client->delegate_id = $delegate->id;
                    $Delegate_client->save();
                }

            }
        }
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('s_p_delegates.index', ['type' => $delegate->work])->with($notification);
    }

    public function destroy($id)
    {
        $delegate = User::findOrFail($id);
        // $this->authorize('showDelegateServiceProvider', $delegate);

        $delegate->delete();

        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    public function balances(Request $request)
    {
        $delegates = User::orderBy('id', 'desc')->where('work', $request->type)->where('user_type', 'delegate')->paginate(15);
        if (! empty($delegates)) {
            foreach ($delegates as $client) {
                $transactions = ClientTransactions::where('user_id', $client->id);
                $client->count_creditor = $transactions->sum('creditor');

                $client->count_debtor = $transactions->sum('debtor');
            }

        }

        return view('service_provider.delegates.balances', compact('delegates'));
    }

    public function transactions(Request $request, $id)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $delegate = User::orderBy('id', 'desc')->where('id', $id)->where('user_type', 'delegate')->first();
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

            return view('service_provider.delegates.balance-transactions', compact('alltransactions', 'transactions', 'delegate', 'from', 'to', 'count_debtor', 'count_creditor', 'count_order_creditor', 'count_order_debtor'));
        } else {
            abort(404);
        }
    }
}
