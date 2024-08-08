<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\Delegate_work;
use App\Exports\BalanceTransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Orders_rules;
use App\Models\OrderRulesDetail;





class DelegateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_delegate', ['only'=>'index', 'show']);
        $this->middleware('permission:add_delegate', ['only'=>'create', 'store']);
        $this->middleware('permission:edit_delegate', ['only'=>'edit', 'update']);
        $this->middleware('permission:delete_delegate', ['only'=>'destroy']);
       
        $this->middleware('permission:show_follow', ['only' => 'tracking', 'livetracking', 'trackingdelegates']);
       
    }

    public function index(Request $request)
    {
        $type=$request->type;
        $this->authorize('checkTypeDelegateCreate', [User::class, $request->type]);
        if($type==NULL)
        {        
            $delegates = User::where('company_id',Auth()->user()->company_id)->where('user_type', 'delegate')->orderBy('id', 'desc')->paginate(25);


        }else{
          
            $delegates = User::where('company_id',Auth()->user()->company_id)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($type) {
                $query->where('work', $type);
            })->orderBy('id', 'desc')->paginate(25);


        }
        return view('admin.delegates.index', compact('delegates','type'));

     
    }

    public function orders($id)
    {
        $delegate = User::findOrFail($id);
        $orders = $delegate->ordersDelegate()->orderBy('id', 'desc')->get();

        return view('admin.delegates.orders', compact('orders'));
    }

    public function create(Request $request)
    {
        // $this->authorize('checkTypeDelegateCreate', [User::class, $request->type]);

      
            $code = codegenerateDelegate();
            $type = $request->type;
            //
            if ($type == null) {
                $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->orderBy('id', 'desc')->get();
                $service_providers = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'service_provider')->get();

            } else {
                $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->where('work', $type)->orderBy('id', 'desc')->get();
                $service_providers = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'service_provider')->whereHas('user_works', function ($query) use ($type) {
                    $query->where('work', $type);
                })->orderBy('id', 'desc')->get();

            }
            $supervisors = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'supervisor')->orderBy('id', 'desc')->get();
 $cities = City::get();

            $Vehicles = Vehicle::where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->get();

            //
            return view('admin.delegates.add', compact('cities', 'type', 'clients', 'supervisors', 'service_providers', 'Vehicles', 'code'));
    
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
            'code' => 'required|max:7|unique:users,code',
            'email' => 'nullable|email|unique:users',
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
        $delegateData['work'] = 1;
        $delegateData['company_id'] = Auth()->user()->company_id;

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
        foreach($request->works as $work)
        {

        
        $Company_work=new Delegate_work();
        $Company_work->delegate_id=$delegate->id;
        $Company_work->work=$work;
        $Company_work->save();

        }
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

        return redirect()->route('delegates.index')->with($notification);
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

        $this->authorize('showDelegateCompany', [User::class, $delegate]);

       
            $supervisor = $delegate->Supervisors->pluck('manger_id')->toArray();
            $supervisors = User::whereIn('id', $supervisor)->get();
            $statuses = Status::where('company_id', Auth()->user()->company_id)->orderBy('sort', 'ASC')->get();
            $Delegate_clients = Delegate_client::where('delegate_id', $delegate->id)->get();

            return view('admin.delegates.show', compact('delegate', 'statuses', 'supervisors', 'Delegate_clients'));
       
    }

    public function edit(User $delegate)
    {
        $this->authorize('showDelegateCompany', [User::class, $delegate]);

      
            $works=Delegate_work::where('delegate_id',$delegate->id)->pluck('work')->toArray();

 $cities = City::get();

            $region = Neighborhood::where('id', $delegate->region_id)->first();
            $Delegate_client = Delegate_client::where('delegate_id', $delegate->id)->pluck('client_id')->toArray();
           
                $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->whereIn('work', $works)->orderBy('id', 'desc')->get();
                $service_providers = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'service_provider')->whereHas('user_works', function ($query) use ($works) {
                    $query->whereIn('work', $works);
                })->orderBy('id', 'desc')->get();

            
            $Delegate_Mangers = Delegate_Manger::where('delegate_id', $delegate->id)->pluck('manger_id')->toArray();
            $supervisors = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'supervisor')->orderBy('id', 'desc')->get();

            $Vehicles = Vehicle::where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->get();

            return view('admin.delegates.edit', compact('works','delegate', 'cities', 'region', 'clients', 'Delegate_client', 'service_providers', 'supervisors', 'Delegate_Mangers', 'Vehicles'));
      
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|max:7|unique:users,code,'.$id,
            // 'email' => 'unique:users,email,'.$id,
            'phone' => 'required|max:10|starts_with:05|unique:users,phone,'.$id,
            'Residency_number' => 'required|max:10',
            'avatar' => 'mimes:jpeg,png,jpg',
            'residence_photo' => 'mimes:jpeg,png,jpg',
            'license_photo' => 'mimes:jpeg,png,jpg',

        ]);
        $delegateData = $request->all();

        $delegate = User::findOrFail($id);
        if ($request->password) {
            $request->validate([
                'password' => 'min:8|confirmed',
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
        $delegate->update($delegateData);
        Delegate_work::where('delegate_id',$delegate->id)->delete();
        foreach($request->works as $work)
        {
           
                $Company_work=new Delegate_work();
                $Company_work->delegate_id=$delegate->id;
                $Company_work->work=$work;
                $Company_work->save();
            
        }

        if ($request->client) {
            Delegate_client::where('delegate_id', $delegate->id)->delete();

            foreach ($request->client as $client_id) {

                $Delegate_client = new Delegate_client();
                $Delegate_client->client_id = $client_id;
                $Delegate_client->delegate_id = $delegate->id;
                $Delegate_client->save();

            }
        }
        if ($request->manger_name) {
            Delegate_Manger::where('delegate_id', $delegate->id)->delete();
            foreach ($request->manger_name as $manger_id) {

                $Delegate_Manger = new Delegate_Manger();
                $Delegate_Manger->manger_id = $manger_id;
                $Delegate_Manger->delegate_id = $delegate->id;
                $Delegate_Manger->save();

            }
        }
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('delegates.index')->with($notification);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
       

            Delegate_client::where('delegate_id', $user->id)->delete();
            Delegate_Manger::where('delegate_id', $user->id)->delete();
            Delegate_work::where('delegate_id', $user->id)->delete();

            $orderR=Orders_rules::where('delegate_id',$user->id)->first();
            OrderRulesDetail::where('order_rules_id',$orderR->id)->delete();
            $orderR->delete();
            if ($user->company_id != Auth()->user()->company_id) {
                return redirect()->back()->with('error', 'لا يوجد هذا المندوب فى حسابك');
            }
            User::findOrFail($id)->delete();
            $notification = [
                'message' => '<h3>Delete Successfully</h3>',
                'alert-type' => 'success',
            ];

            return back()->with($notification);
        
    }

    public function balances(Request $request)
    {
        $this->authorize('checkTypeDelegateCreate', [User::class, $request->type]);

           if($request->type==null)
           {
            $delegates = User::orderBy('id', 'desc')->where('company_id', Auth()->user()->company_id)->where('user_type', 'delegate')->paginate(25);

           }else{
            $type=$request->type;
            $delegates = User::where('company_id',Auth()->user()->company_id)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($type) {
                $query->where('work', $type);
            })->orderBy('id', 'desc')->paginate(25);
           }
      
            if (! empty($delegates)) {
                foreach ($delegates as $client) {
                    $transactions = ClientTransactions::where('user_id', $client->id);
                    $client->count_creditor = $transactions->sum('creditor');

                    $client->count_debtor = $transactions->sum('debtor');
                }

            }
            $type = $request->type;

            return view('admin.delegates.balances', compact('delegates', 'type'));
      
    }

    public function transactions(Request $request, $id)
    {
          switch ($request->input('action')) {
            case 'export':
                $delegate=User::findOrFail($id);
                $file_name=$delegate->name.'_transactions.xlsx';
                return Excel::download(new BalanceTransactionExport($delegate->id,$request),$file_name);                
                break;
            }

        
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
    
                    return view('admin.delegates.balance-transactions', compact('alltransactions', 'transactions', 'delegate', 'from', 'to', 'count_debtor', 'count_creditor', 'count_order_creditor', 'count_order_debtor'));
                } else {
                    abort(404);
                }

      
      
       
    }

 
    // 
    public function transactionStore(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'description' => 'required',
        ]);

        $client = User::find($request->user_id);
        
            $data = $request->all();
            $amount = 0.00;
            if ($request->debtor) {
                $amount = $request->debtor;
            } elseif ($request->amount) {
                $amount = $request->amount;
            }
            if ($request->hasFile('image')) {
                $image = 'avatar/transactions/'.$request->file('image')->hashName();
                $uploaded = $request->file('image')->storeAs('public', $image);
                if ($uploaded) {
                    $data['image'] = $image;
                }
            }
            if ($request->type == 'debtor') {
                $data['debtor'] = $amount;
                $data['creditor'] = 0.00;
                $data['transaction_type_id'] = 7;

                ClientTransactions::create($data);

            } elseif ($request->type == 'creditor') {

                $data['creditor'] = $amount;
                $data['debtor'] = 0.00;
                $data['transaction_type_id'] = 8;

                ClientTransactions::create($data);
            }

            return back()->with('success', 'Save Successfully');
       

    }

    public function transactionDestroy($id)
    {
        $Transactions = ClientTransactions::findOrFail($id);
        $client = User::findOrFail($Transactions->user_id);

            ClientTransactions::findOrFail($id)->delete();
            $notification = [
                'message' => '<h3>Delete Successfully</h3>',
                'alert-type' => 'success',
            ];

            return back()->with($notification);
       
    }







    //
    public function tracking()
    {
        $delegates = User::where('user_type', 'delegate')->where('company_id', Auth()->user()->company_id)->where('is_active', 1)->orderBy('id', 'desc')->paginate(25);

        return view('admin.delegates.tracking', compact('delegates'));
    }

    public function livetracking($id)
    {
        $delegate_id = $id;

        return view('admin.delegates.livetracking', compact('delegate_id'));

    }

    public function trackingdelegates()
    {
        $Users = User::where('user_type', 'delegate')->where('is_active', 1)->where('company_id', Auth()->user()->company_id)->get();

        return view('admin.delegates.trackingdelegates', compact('Users'));
    }

    public function activation($id)
    {
        $delegate = User::find($id);
        if ($delegate->is_active == 1) {
            $delegate->is_active = 0;
            $delegate->save();

        } else {
            $delegate->is_active = 1;
            $delegate->save();

        }

        return back();

    }
}
