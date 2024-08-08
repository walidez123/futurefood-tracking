<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\Company_setting;
use App\Models\Company_work;
use App\Models\CompanyCost;
use App\Models\CompanyTransaction;
use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class companiesController extends Controller
{
    public function __construct()
    {
        //   $this->middleware('permission:show_client', ['only'=>'index', 'show', 'api']);
        // $this->middleware('permission:show_resturant', ['only'=>'index', 'show', 'api']);

        // $this->middleware('permission:add_client', ['only'=>'create', 'store']);
        // $this->middleware('permission:add_resturant', ['only'=>'create', 'store']);

        // $this->middleware('permission:edit_client', ['only'=>'edit', 'update', 'apiStore']);
        // $this->middleware('permission:edit_resturant', ['only'=>'edit', 'update', 'apiStore']);

        // $this->middleware('permission:delete_client', ['only'=>'destroy', 'apiDestroy']);
        // $this->middleware('permission:delete_resturant', ['only'=>'destroy', 'apiDestroy']);

        // $this->middleware('permission:show_balances', ['only'=>'balances', 'transactions']);
        // $this->middleware('permission:show_balance_res', ['only'=>'balances', 'transactions']);
        // $this->middleware('permission:add_balances', ['only'=>'transactionStore']);

        // $this->middleware('permission:add_balance_res', ['only'=>'transactionStore']);
        // $this->middleware('permission:delete_balances', ['only'=>'transactionDestroy',]);
        // $this->middleware('permission:delete_balance_res', ['only'=>'transactionDestroy',]);

        // Unique Token
        $this->apiToken = uniqid(base64_encode(str_random(60)));
    }

    public function index(Request $request)
    {
        $companies = User::where('user_type', 'admin')->where('is_company', 1)->orderBy('id', 'desc')->paginate(25);

        return view('super_admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('super_admin.companies.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                              => 'required',
            'store_name'                        => 'required',
            'email'                             => 'required|email|unique:users',
            'phone'                             => 'required|unique:users,phone',
            'password'                          => 'required|min:8|confirmed',
            'tax_Number'                        => 'required',
            'bank_swift'                        => 'required',
            'bank_account_number'               => 'required',
            'bank_name'                         => 'required',
            'lastmile_cost'                     => 'required',
            'food_delivery_cost'                => 'required',
            'warehouse_cost'                    => 'required',
            'fulfillment_cost'                  => 'required',
            'salla_cost'                        => 'required',
            'foodics_cost'                      => 'required',
            'zid_cost'                          => 'required',
        ]);
        $webSetting = WebSetting::findOrFail(1);
        $clientData = $request->all();
        $clientData['password'] = bcrypt($request->password);
        $clientData['user_type'] = 'admin';
        $clientData['is_company'] = 1;
        $clientData['role_id'] = 1;
        $clientData['avatar'] = $webSetting->logo;

        if ($request->hasFile('Tax_certificate')) {
            $Tax_certificate = 'avatar/admin/'.$request->file('Tax_certificate')->hashName();
            $uploaded = $request->file('Tax_certificate')->storeAs('public', $Tax_certificate);
            if ($uploaded) {
                $clientData['Tax_certificate'] = $Tax_certificate;
            }
        }

        if ($request->hasFile('commercial_register')) {
            $commercial_register = 'avatar/admin/'.$request->file('commercial_register')->hashName();
            $uploaded = $request->file('commercial_register')->storeAs('public', $commercial_register);
            if ($uploaded) {
                $clientData['commercial_register'] = $commercial_register;
            }
        }
        $client = User::create($clientData);
        $client->company_id = $client->id;
        $client->save();
        // add work company
        $company_costs = CompanyCost::create([
            'user_id' => $client->id,
            'lastmile_cost'=> $request->lastmile_cost,
            'food_dlivery_cost'=> $request->food_dlivery_cost,
            'warehouse_cost'=> $request->warehouse_cost,
            'fulfillment_cost'=> $request->fulfillment_cost,
            'salla_cost'=> $request->salla_cost,
            'foodics_cost'=> $request->foodics_cost,
            'zid_cost'=> $request->zid_cost,
        ]);
        foreach ($request->works as $work) {
            $Company_work = new Company_work();
            $Company_work->company_id = $client->id;
            $Company_work->work = $work;
            $Company_work->save();
        }
        //end
        $allStatus = Status::where('company_id', null)->first();
        $this->save_defult_status($client->id);

        $this->defultSetting($client, $allStatus);
        if ($client) {
            // Mail::to($client->email)->send(new WelcomeEmail($client->name));
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

        return redirect()->route('companies.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $company)
    {

        return view('super_admin.companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $company)
    {
        $works = Company_work::where('company_id', $company->id)->pluck('work')->toArray();

        return view('super_admin.companies.edit', compact('company', 'works'));
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
            'name'                 => 'required',
            'store_name'           => 'required',
            'email'                => 'required|unique:users,email,' . $id,
            'phone'                => 'required|unique:users,phone,' . $id,
            'tax_Number'           => 'required',
            'bank_swift'           => 'required',
            'bank_account_number'  => 'required',
            'bank_name'            => 'required',
            'lastmile_cost'        => 'required',
            'food_delivery_cost'   => 'required',
            'warehouse_cost'       => 'required',
            'fulfillment_cost'     => 'required',
            'salla_cost'           => 'required',
            'foodics_cost'         => 'required',
            'zid_cost'         => 'required',
        ]);

        $clientData = $request->all();
        $client = User::findOrFail($id);
        if ($request->password) {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);
            $clientData['password'] = bcrypt($request->password);
            if ($request->hasFile('Tax_certificate')) {
                $Tax_certificate = 'avatar/admin/'.$request->file('Tax_certificate')->hashName();
                $uploaded = $request->file('Tax_certificate')->storeAs('public', $Tax_certificate);
                if ($uploaded) {
                    $clientData['Tax_certificate'] = $Tax_certificate;
                }
            }

            if ($request->hasFile('commercial_register')) {
                $commercial_register = 'avatar/admin/'.$request->file('commercial_register')->hashName();
                $uploaded = $request->file('commercial_register')->storeAs('public', $commercial_register);
                if ($uploaded) {
                    $clientData['commercial_register'] = $commercial_register;
                }
            }

            $client->update($clientData);
        } else {

            if ($request->hasFile('Tax_certificate')) {
                $Tax_certificate = 'avatar/admin/'.$request->file('Tax_certificate')->hashName();
                $uploaded = $request->file('Tax_certificate')->storeAs('public', $Tax_certificate);
                if ($uploaded) {
                    $clientData['Tax_certificate'] = $Tax_certificate;
                }
            }

            if ($request->hasFile('commercial_register')) {
                $commercial_register = 'avatar/admin/'.$request->file('commercial_register')->hashName();
                $uploaded = $request->file('commercial_register')->storeAs('public', $commercial_register);
                if ($uploaded) {
                    $clientData['commercial_register'] = $commercial_register;
                }
            }
            $client->update($request->except(['password']));

        }
        $company_cost = CompanyCost::where('user_id', $client->id)->first();
        if ($company_cost) {
            $company_cost->update([
                'lastmile_cost'=> $request->lastmile_cost,
                'food_delivery_cost'=> $request->food_delivery_cost,
                'warehouse_cost'=> $request->warehouse_cost,
                'fulfillment_cost'=> $request->fulfillment_cost,
                'salla_cost'=> $request->salla_cost,
                'foodics_cost'=> $request->foodics_cost,
                'zid_cost'=> $request->zid_cost,
            ]);
        } else {
            $company_costs = CompanyCost::create([
                'user_id' => $client->id,
                'lastmile_cost'=> $request->lastmile_cost,
                'food_delivery_cost'=> $request->food_delivery_cost,
                'warehouse_cost'=> $request->warehouse_cost,
                'fulfillment_cost'=> $request->fulfillment_cost,
                'salla_cost'=> $request->salla_cost,
                'foodics_cost'=> $request->foodics_cost,
                'zid_cost'=> $request->zid_cost,
            ]);
        }

        Company_work::where('company_id', $client->id)->delete();

        foreach ($request->work as $work) {

            $Company_work = new Company_work();
            $Company_work->company_id = $client->id;
            $Company_work->work = $work;
            $Company_work->save();

        }
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('companies.index')->with($notification);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->company_active == 0) {
            $user->company_active = 1;
            $user->save();
        } else {
            $user->company_active = 0;
            $user->save();
        }

        $notification = [
            'message' => '<h3>تم التحويل بنجاح</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    public function orders($id)
    {
        $orders = Order::where('company_id', $id)->get();
        $company = User::findorfail($id);

        return view('super_admin.companies.orders', compact('orders', 'company'));
    }

    public function setting($id)
    {
        $company = User::findorfail($id);
        // dd($company);
        $setiing = Company_setting::where('company_id', $id)->first();
        $Status = Status::where('company_id', null)->get();
        $setiing_type = Company_work::where('company_id', $id)->pluck('work')->toArray();
        if (is_null($setiing)) {
            return view('super_admin.companies.setting.add', compact('company'));
        } else {
            return view('super_admin.companies.setting.edit', compact('company', 'setiing', 'Status', 'setiing_type'));
        }
    }

    public function setting_store(request $request)
    {
        $clientData = $request->all();
        $client = Company_setting::create($clientData);
        if ($client) {
            // Mail::to($client->email)->send(new WelcomeEmail($client->name));
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

        return redirect()->route('companies.index')->with($notification);
    }

    public function setting_edit(request $request)
    {

        //
        $SettingData = $request->all();
        if ($request->hasFile('logo')) {
            $avatar = 'avatar/'.'company'.'/'.$request->file('logo')->hashName();
            $uploaded = $request->file('logo')->storeAs('public', $avatar);
            if ($uploaded) {
                $SettingData['logo'] = $avatar;
            }
        }
        $user = Auth()->user();
        $setting = Company_setting::findorfail($request->id);
        $setting->update($SettingData);
        if ($setting) {
            // Mail::to($client->email)->send(new WelcomeEmail($client->name));
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

        return redirect()->route('companies.index')->with($notification);
    }

    private function defultSetting($client, $status)
    {
        $company['company_id'] = $client->company_id;
        $company['name'] = $client->name;
        $company['email'] = $client->email;
        $company['address'] = $client->address;
        $company['phone'] = $client->phone;
        $company['status_pickup'] = $status->id;
        $company['status_pickup_res'] = $status->id;
        $company['status_return_shop'] = $status->id;
        $company['status_return_res'] = $status->id;
        $company['status_can_return_shop'] = $status->id;
        $company['status_can_return_res'] = $status->id;
        $company['status_shop'] = $status->id;
        $company['status_res'] = $status->id;

        Company_setting::create($company);
    }

    private function save_defult_status($id)
    {
        $allStatus = Status::where('company_id', null)->get();
        foreach ($allStatus as $i => $defult) {
            $status = new Status();
            $status->title = $defult->title;
            $status->title_ar = $defult->title_ar;
            $status->delegate_appear = $defult->delegate_appear;
            $status->restaurant_appear = $defult->restaurant_appear;
            $status->shop_appear = $defult->shop_appear;
            $status->otp_send_code = $defult->otp_send_code;
            $status->company_id = $id;
            $status->storehouse_appear = $defult->storehouse_appear;
            $status->client_appear = $defult->client_appear;
            $status->send_image = $defult->send_image;
            $status->sort = $i + 1;
            $status->save();
        }
    }

    public function balances(Request $request)
    {
        $companies = User::where('user_type', 'admin')->where('is_company', 1)->orderBy('id', 'desc')->paginate(25);
        if ($companies) {
            foreach ($companies as $client) {
                $transactions = CompanyTransaction::where('user_id', $client->id);

                $client->count_creditor = $transactions->sum('creditor');

                $client->count_debtor = $transactions->sum('debtor');
            }

        }

        return view('super_admin.companies.balances', compact('companies'));
    }

    public function transactions(Request $request, $id)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $company = User::where('user_type', 'admin')->where('id', $id)->where('is_company', 1)->first();

        if ($company) {
            $transactions = CompanyTransaction::where('user_id', $id);
            if ($from != null && $to != null) {
                $transactions = $transactions->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to);
            }
            $alltransactions = $transactions->orderBy('id', 'desc')->paginate(50);

            $count_creditor = $transactions->sum('creditor');
            $count_debtor = $transactions->sum('debtor');

            $count_order_creditor = $transactions->whereNotNull('order_id')->sum('creditor');

            $count_order_debtor = $transactions->whereNotNull('order_id')->sum('debtor');

            return view('super_admin.companies.balance-transactions', compact('alltransactions', 'company', 'from', 'to', 'count_debtor', 'count_creditor', 'count_order_debtor', 'count_order_creditor'));
        } else {
            abort(404);
        }
    }

    public function transactionStore(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'description' => 'required',
        ]);

        // $client = User::find($request->user_id);
        // $this->authorize('checkType', [User::class, $client->work]);

        // if ($this->testPermission_add($client) == 'yes') {
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

            CompanyTransaction::create($data);

        } elseif ($request->type == 'creditor') {

            $data['creditor'] = $amount;
            $data['debtor'] = 0.00;
            $data['transaction_type_id'] = 8;

            CompanyTransaction::create($data);
        }

        return back()->with('success', 'Save Successfully');
        // } else {
        //     return redirect(url(Auth()->user()->user_type));
        // }

    }

    public function transactionDestroy($id)
    {
        $Transactions = CompanyTransaction::findOrFail($id);
        // $client = User::findOrFail($Transactions->user_id);
        // $this->authorize('checkType', [User::class, $client->work]);

        // if ($this->testPermission_destroy($client) == 'yes') {
        CompanyTransaction::findOrFail($id)->delete();

        return back()->with('success', 'Save Successfully');
        // } else {
        //     return redirect(url(Auth()->user()->user_type));
        // }
    }
}
