<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\OrderRulesDetail;
use App\Models\Orders_rules;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignOrdersRule extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_Orders_rules', ['only' => 'index', 'show']);
        $this->middleware('permission:add_Orders_rules', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_Orders_rules', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_Orders_rules', ['only' => 'destroy']);
    }

    public function index()
    {
        $rules = Orders_rules::where('company_id', Auth()->user()->company_id)->where('type', 1)->orderBy('id','desc')->paginate(25);

        return view('admin.Assign.index', compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cites = City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->orderBy('company_id', 'DESC')->get();
        $regions = Neighborhood::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->orderBy('company_id', 'DESC')->get();
        $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->get();
        $delegates = User::where('user_type', 'delegate')->where('is_active', 1)->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->get();

        return view('admin.Assign.add', compact('cites', 'regions', 'delegates', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $date = json_decode(request('conditionsArray'), true);

        $validationRules = [
            'status' => 'required',
            'details' => 'required',
            'work_type' => 'required',
            'delegate_id' => 'required',
            'designation_name' => 'required',
        ];
        $validator = \Validator::make($date['orderRules'], $validationRules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            DB::transaction(function () use ($date) {
                $Orders_rules = new Orders_rules;
                $Orders_rules->max = isset($date['orderRules']['max']) ? $date['orderRules']['max'] : null;
                $Orders_rules->status = isset($date['orderRules']['status']) ? $date['orderRules']['status'] : null;
                $Orders_rules->details = isset($date['orderRules']['details']) ? $date['orderRules']['details'] : null;
                $Orders_rules->work_type = isset($date['orderRules']['work_type']) ? $date['orderRules']['work_type'] : null;
                $Orders_rules->company_id = isset($date['orderRules']['company_id']) ? $date['orderRules']['company_id'] : Auth()->user()->company_id;
                $Orders_rules->delegate_id = isset($date['orderRules']['delegate_id']) ? $date['orderRules']['delegate_id'] : null;
                $Orders_rules->created_date = isset($date['orderRules']['created_date']) ? $date['orderRules']['created_date'] : null;
                $Orders_rules->title = isset($date['orderRules']['designation_name']) ? $date['orderRules']['designation_name'] : null;
                $Orders_rules->created_by = auth()->id();
                $Orders_rules->type = 1;

                $Orders_rules->save();
                if (isset($date['orderRulesDetails'])) {
                    foreach ($date['orderRulesDetails'] as $details) {
                        $OrderRulesDetail = new OrderRulesDetail;
                        $OrderRulesDetail->cod = isset($details['cod']) ? $details['cod'] : null;
                        $OrderRulesDetail->client_id = isset($details['client_id']) ? $details['client_id'] : null;
                        $OrderRulesDetail->address_id = isset($details['address_id']) ? $details['address_id'] : null;
                        $OrderRulesDetail->city_from = isset($details['city_from']) ? $details['city_from'] : null;
                        $OrderRulesDetail->city_to = isset($details['city_to']) ? $details['city_to'] : null;
                        $OrderRulesDetail->region_from = isset($details['region_from']) ? $details['region_from'] : null;
                        $OrderRulesDetail->region_to = isset($details['region_to']) ? $details['region_to'] : null;
                        $OrderRulesDetail->order_rules_id = $Orders_rules->id;
                        $OrderRulesDetail->save();
                    }
                }
            });
            $notification = [
                'message' => '<h3>Saved Successfully</h3>',
                'alert-type' => 'success',
            ];

            return redirect()->route('AssignOrdersRule.index')->with($notification);
        }
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
        // 
        
        $Orders_rules = Orders_rules::findOrFail($id);
        $this->authorize('order_rules_show', $Orders_rules);

        $cites = City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->orderBy('company_id', 'DESC')->get();
        $regions = Neighborhood::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->orderBy('company_id', 'DESC')->get();
        $clients = User::where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->get();
        if ($Orders_rules->work_type == 1) {
            $statuses = Status::where('shop_appear', '1')->where('company_id', Auth()->user()->company_id)->orderBy('sort', 'ASC')->get();
        } elseif($Orders_rules->work_type == 2) {
            $statuses = Status::where('restaurant_appear', '1')->where('company_id', Auth()->user()->company_id)->orderBy('sort', 'ASC')->get();
          
        }
        $work_type=$Orders_rules->work_type;
        $delegates = User::where('company_id',Auth()->user()->company_id)->where('is_active', 1)->where('user_type', 'delegate')->whereHas('delegate_work', function ($query) use ($work_type) {
            $query->where('work', $work_type);
        })->orderBy('id', 'desc')->get();


        return view('admin.Assign.edit', compact('Orders_rules', 'cites', 'regions', 'statuses', 'delegates', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $date = json_decode(request('conditionsArray'), true);
        $validationRules = [
            'status' => 'required',
            'details' => 'required',
            'work_type' => 'required',
            // 'delegate_id'     => 'required',
            'orders_rules_id' => 'required',
            'designation_name' => 'required',
        ];
        $validator = \Validator::make($date['orderRules'], $validationRules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            DB::transaction(function () use ($date) {
                $Orders_rules = Orders_rules::find($date['orderRules']['orders_rules_id']);
                $Orders_rules->max = isset($date['orderRules']['max']) ? $date['orderRules']['max'] : null;
                $Orders_rules->status = isset($date['orderRules']['status']) ? $date['orderRules']['status'] : null;
                $Orders_rules->details = isset($date['orderRules']['details']) ? $date['orderRules']['details'] : null;
                $Orders_rules->work_type = isset($date['orderRules']['work_type']) ? $date['orderRules']['work_type'] : null;
                $Orders_rules->delegate_id = isset($date['orderRules']['delegate_id']) ? $date['orderRules']['delegate_id'] : null;
                $Orders_rules->created_date = isset($date['orderRules']['created_date']) ? $date['orderRules']['created_date'] : null;
                $Orders_rules->title = isset($date['orderRules']['designation_name']) ? $date['orderRules']['designation_name'] : null;
                $Orders_rules->save();
                if (isset($date['orderRulesDetails'])) {
                    foreach ($date['orderRulesDetails'] as $details) {
                        $OrderRulesDetail = new OrderRulesDetail;
                        $OrderRulesDetail->cod = isset($details['cod']) ? $details['cod'] : null;
                        $OrderRulesDetail->client_id = isset($details['client_id']) ? $details['client_id'] : null;
                        $OrderRulesDetail->address_id = isset($details['address_id']) ? $details['address_id'] : null;

                        $OrderRulesDetail->city_from = isset($details['city_from']) ? $details['city_from'] : null;
                        $OrderRulesDetail->city_to = isset($details['city_to']) ? $details['city_to'] : null;
                        $OrderRulesDetail->region_from = isset($details['region_from']) ? $details['region_from'] : null;
                        $OrderRulesDetail->region_to = isset($details['region_to']) ? $details['region_to'] : null;
                        $OrderRulesDetail->order_rules_id = $Orders_rules->id;
                        $OrderRulesDetail->save();
                    }
                }
            });
            $notification = [
                'message' => '<h3>Saved Successfully</h3>',
                'alert-type' => 'success',
            ];

            return redirect()->route('AssignOrdersRule.index')->with($notification);
        }
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
        OrderRulesDetail::where('order_rules_id',$id)->delete();

        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    public function delete_orders_rule_details($id)
    {
        OrderRulesDetail::findOrFail($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
