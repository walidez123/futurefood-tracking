<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Orders_rules;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CompanyServiceProvider;

class Rule_service_providerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_orders_rules_service_provider', ['only' => 'index', 'show']);
        $this->middleware('permission:add_orders_rules_service_provider', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_orders_rules_service_provider', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_orders_rules_service_provider', ['only' => 'destroy']);
    }

    public function index()
    {
        $rules = Orders_rules::where('company_id', Auth()->user()->company_id)->where('type', 2)->paginate(25);

        return view('admin.Assign_service_provider.index', compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->get();
        $service_providers = User::where('user_type', 'service_provider')->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->get();
        $service_providers = CompanyServiceProvider::where('company_id', Auth()->user()->company_id)->where('is_active', 1)->orderBy('id', 'desc')->get();

        return view('admin.Assign_service_provider.add', compact('service_providers', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {
        $request->validate([
            'status' => 'required',
            'details' => 'required',
            'work_type' => 'required',
            'delegate_id' => 'required',
            'title' => 'required',
        ]);

        $Orders_rules = Orders_rules::create($request->all());

        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('Rule_service_provider.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Orders_rules = Orders_rules::findOrFail($id);
        $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->get();
        if ($Orders_rules->work_type == 1) {
            $service_providers = CompanyServiceProvider::where('company_id', Auth()->user()->company_id)->where('is_active', 1)
            ->whereHas('user_works', function ($query)  {
                $query->where('work', 1);
            })->orderBy('id', 'desc')->get();

        } elseif ($Orders_rules->work_type == 2) {
            $service_providers = CompanyServiceProvider::where('company_id', Auth()->user()->company_id)->where('is_active', 1)
            ->whereHas('user_works', function ($query) {
                $query->where('work', 2);
            })->orderBy('id', 'desc')->get();
        } else {
            $service_providers = CompanyServiceProvider::where('company_id', Auth()->user()->company_id)->where('is_active', 1)
            ->whereHas('user_works', function ($query)  {
                $query->where('work', 4);
            })->orderBy('id', 'desc')->get();
        }
        $addresses = Address::where('user_id', $Orders_rules->client_id)->get();

        return view('admin.Assign_service_provider.edit', compact('Orders_rules', 'addresses', 'service_providers', 'clients'));
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

            'status' => 'required',
            'details' => 'required',
            'work_type' => 'required',
            'delegate_id' => 'required',
            'orders_rules_id' => 'required',
            'title' => 'required',
        ]);

        $Orders_rules = Orders_rules::findOrFail($id);
        $Orders_rules->update($request->all());
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('Rule_service_provider.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Orders_rules::findOrFail($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
