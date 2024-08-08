<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Address;
use App\Models\City;
use App\Models\Client_good;
use App\Models\ClientTransactions;
use App\Models\Company_setting;
use App\Models\Good;
use App\Models\Neighborhood;
use App\Models\Order;
use App\Models\Package;
use App\Models\Size;
use App\Models\Status;
use App\Models\User;
use App\Models\User_package;
use App\Models\UserCost;
use App\Models\PaletteSubscription;
use App\Models\UserStatus;
use App\Models\Zone;
use App\Models\Zone_account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\BalanceTransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;


class ClientController extends Controller
{
    protected $apiToken;
    public function __construct()
    {

        $this->middleware('permission:show_api_client', ['only' => 'api']);
        $this->middleware('permission:add_api_client', ['only' => 'apiStore']);
        $this->middleware('permission:delete_api_client', ['only' => 'apiDestroy']);
        $this->middleware('permission:show_address', ['only' => 'addresses']);
        $this->middleware('permission:add_address', ['only' => 'address_create', 'address_store']);
        $this->middleware('permission:edit_address', ['only' => 'address_edit', 'Address_update']);
        $this->middleware('permission:delete_address', ['only' => 'address_delete']);

        // Unique Token
        $this->apiToken = uniqid(base64_encode(str_random(60)));
    }

    public function index(Request $request)
    {
        $this->authorize('checkType', [User::class, $request->type]);

        
        if (($request->type == 1 && in_array('show_client', app('User_permission'))) ||
            $request->type == 2 && in_array('show_resturant', app('User_permission')) ||
            $request->type == 3 && in_array('show_client_warehouse', app('User_permission')) ||
            $request->type == 4 && in_array('show_client_fulfillment', app('User_permission'))) {
            $work = $request->type;
            $clients = User::where('user_type', 'client')->where('work', $request->type)->where('company_id', Auth()->user()->company_id)->orderBy('id', 'desc')->paginate(25);

            return view('admin.clients.index', compact('clients', 'work'));
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('checkType', [User::class, $request->type]);

        if (($request->type == 1 && in_array('add_client', app('User_permission'))) ||
            $request->type == 2 && in_array('add_resturant', app('User_permission')) ||
            $request->type == 3 && in_array('add_client_warehouse', app('User_permission')) ||
            $request->type == 4 && in_array('add_client_fulfillment', app('User_permission'))
        ) {

            $work = $request->type;
            $statuses = Status::where('company_id', Auth()->user()->company_id)->orderBy('sort', 'ASC')->get();
 $cities = City::get();

            $zones = Zone::where('company_id', Auth()->user()->company_id)->where('type', 'city')->get();
            $companySetting = Company_setting::where('company_id', auth()->user()->company_id)->first();
            if ($request->type == 3) {
                $goods = Good::where('company_id', Auth()->user()->company_id)->where('client_id', null)->get();
                $sizes = Size::where('company_id', Auth()->user()->company_id)->get();
                $offers = Package::where('publish', 1)->where('company_id', Auth()->user()->company_id)->get();

                return view('admin.clients.add_warehouse', compact('statuses', 'cities', 'work', 'sizes', 'goods', 'offers'));

            }

            return view('admin.clients.add', compact('statuses', 'cities', 'work', 'zones', 'companySetting'));
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    public function store(CreateUserRequest $request)
    {
        $this->authorize('checkType', [User::class, $request->work]);

        if (($request->work == 1 && in_array('add_client', app('User_permission'))) ||
            $request->work == 2 && in_array('add_resturant', app('User_permission')) ||
            $request->work == 3 && in_array('add_client_warehouse', app('User_permission')) ||
            $request->work == 4 && in_array('add_client_fulfillment', app('User_permission'))) {

            $clientData = $request->all();
            $clientData['password'] = bcrypt($request->password);
            $clientData['company_id'] = Auth()->user()->company_id;

            if ($request->hasFile('Tax_certificate')) {
                $Tax_certificate = 'avatar/client/'.$request->file('Tax_certificate')->hashName();
                $uploaded = $request->file('Tax_certificate')->storeAs('public', $Tax_certificate);
                if ($uploaded) {
                    $clientData['Tax_certificate'] = $Tax_certificate;
                }
            }
            if ($request->hasFile('signed_contract')) {
                $signed_contract = 'avatar/client/'.$request->file('signed_contract')->hashName();
                $uploaded = $request->file('signed_contract')->storeAs('public', $signed_contract);
                if ($uploaded) {
                    $clientData['signed_contract'] = $signed_contract;
                }
            }

            if ($request->hasFile('commercial_register')) {
                $commercial_register = 'avatar/client/'.$request->file('commercial_register')->hashName();
                $uploaded = $request->file('commercial_register')->storeAs('public', $commercial_register);
                if ($uploaded) {
                    $clientData['commercial_register'] = $commercial_register;
                }
            }
            if ($request->hasFile('avatar')) {
                $avatar = 'avatar/client'.$request->user_type.'/'.$request->file('avatar')->hashName();
                $uploaded = $request->file('avatar')->storeAs('public', $avatar);
                if ($uploaded) {
                    $clientData['avatar'] = $avatar;
                }
            }
            if ($request->work == 4) {
                $client = User::create($clientData);

                $user_cost = UserCost::create([
                    'user_id' => $client->id,
                    'cost_inside_city' => $request->cost_inside_city,
                    'cost_outside_city' => $request->cost_outside_city,
                    'cost_reshipping' => $request->cost_reshipping,
                    'cost_reshipping_out_city' => $request->cost_reshipping_out_city,
                    'fees_cash_on_delivery' => $request->fees_cash_on_delivery,
                    'fees_cash_on_delivery_out_city' => $request->fees_cash_on_delivery_out_city,
                    'pickup_fees' => $request->pickup_fees,
                    'over_weight_per_kilo' => $request->over_weight_per_kilo,
                    'over_weight_per_kilo_outside' => $request->over_weight_per_kilo_outside,
                    'standard_weight' => $request->standard_weight,
                    'standard_weight_outside' => $request->standard_weight_outside,
                    'receive_palette' => $request->receive_palette,
                    'store_palette' => $request->store_palette,
                    'pallet_subscription_type' => $request->pallet_subscription_type,
                    'sort_by_suku' => $request->sort_by_suku,
                    'pick_process_package' => $request->pick_process_package,
                    'print_waybill' => $request->print_waybill,
                    'sort_by_city' => $request->sort_by_city,
                    'store_return_shipment' => $request->store_return_shipment,
                    'reprocess_return_shipment' => $request->reprocess_return_shipment,
                    // 'kilos_number' => $request->kilos_number,
                    // 'additional_kilo_price' => $request->additional_kilo_price,
                ]);

                $user_status = UserStatus::create([
                    'user_id' => $client->id,
                    'default_status_id' => $request->default_status_id,
                    'available_edit_status' => $request->available_edit_status,
                    'available_delete_status' => $request->available_delete_status,
                    'available_collect_order_status' => $request->available_collect_order_status,
                    'available_overweight_status' => $request->available_overweight_status,
                    'available_overweight_status_outside' => $request->available_overweight_status_outside,
                    'calc_cash_on_delivery_status_id' => $request->calc_cash_on_delivery_status_id,
                    'cost_calc_status_id_outside' => $request->cost_calc_status_id_outside,
                    'cost_calc_status_id' => $request->cost_calc_status_id,
                    'cost_reshipping_calc_status_id' => $request->cost_reshipping_calc_status_id,
                    'receive_palette_status_id' => $request->receive_palette_status_id,
                    'store_palette_status_id' => $request->store_palette_status_id,
                    'sort_by_skus_status_id' => $request->sort_by_skus_status_id,
                    'pick_process_package_status_id' => $request->pick_process_package_status_id,
                    'print_waybill_status_id' => $request->print_waybill_status_id,
                    'sort_by_city_status_id' => $request->sort_by_city_status_id,
                    'store_return_shipment_status_id' => $request->store_return_shipment_status_id,
                    'reprocess_return_shipment_status_id' => $request->reprocess_return_shipment_status_id,
                    'shortage_order_quantity_f_stock'=>$request->shortage_order_quantity_f_stock,
                    'restocking_order_quantity_to_stock'=>$request->restocking_order_quantity_to_stock,

                ]);
            } 
         elseif($request->work==3)
        {
            $client = User::create($clientData);

            $user_cost = UserCost::create([
                'user_id' => $client->id,
                'pallet_in' => $request->pallet_in,
                'pallet_out' => $request->pallet_out,
                'packging_pallet' => $request->packging_pallet,
                'segregation_pallet' => $request->segregation_pallet,
                'palletization' => $request->palletization,
                'wooden_pallet' => $request->wooden_pallet,
                'return_pallet' => $request->return_pallet,
                'pallet_shipping' => $request->pallet_shipping,
                
            ]);

            $user_status = UserStatus::create([
                'user_id' => $client->id,
                'pallet_in_status_id' => $request->pallet_in_status_id,
                'pallet_out_status_id' => $request->pallet_out_status_id,
                'packging_pallet_status_id' => $request->packging_pallet_status_id,
                'segregation_pallet_status_id' => $request->segregation_pallet_status_id,
                'palletization_status_id' => $request->palletization_status_id,
                'wooden_pallet_status_id' => $request->wooden_pallet_status_id,
                'return_pallet_status_id' => $request->return_pallet_status_id,
                'pallet_shipping_status_id' => $request->pallet_shipping_status_id,
            ]);


        }
            else {
                $client = User::create($clientData);
            }
            if ($request->zone_id) {
                foreach ($request->zone_id as $i => $zone) {
                    $zone_account = new Zone_account();
                    $zone_account->zone_id = $zone;
                    $zone_account->user_id = $client->id;
                    $zone_account->cost_inside_zone = $request->cost_inside_zone[$i];
                    $zone_account->cost_outside_zone = $request->cost_outside_zone[$i];
                    $zone_account->cost_reshipping_zone = $request->cost_reshipping_zone[$i];
                    $zone_account->cost_reshipping_out_zone = $request->cost_reshipping_out_zone[$i];
                    $zone_account->fees_cash_on_delivery_zone = $request->fees_cash_on_delivery_zone[$i];
                    $zone_account->fees_cash_on_delivery_out_zone = $request->fees_cash_on_delivery_out_zone[$i];
                    $zone_account->pickup_fees_zone = $request->pickup_fees_zone[$i];
                    $zone_account->over_weight_per_kilo_zone = $request->over_weight_per_kilo_zone[$i];
                    $zone_account->over_weight_per_kilo_outside_zone = $request->over_weight_per_kilo_outside_zone[$i];
                    $zone_account->standard_weight_zone = $request->standard_weight_zone[$i];
                    $zone_account->standard_weight_outside_zone = $request->standard_weight_outside_zone[$i];
                    $zone_account->save();
                }
            }
            //
            if ($request->goods) {
                foreach ($request->goods as $good) {
                    $Client_good = new Client_good();
                    $Client_good->user_id = $client->id;
                    $Client_good->good_id = $good;
                    $Client_good->save();
                }
            }
            if ($request->offer_id) {
                $date = Carbon::createFromFormat('Y-m-d', $request->start_date);
                $daysToAdd = $request->num_day;
                $daysToAdd=($daysToAdd-1);
                $date = $date->addDays($daysToAdd);
                Log::info('Days to Add:', ['num_days' => $request->num_day]);

                $User_package = new User_package();
                $User_package->user_id = $client->id;
                $User_package->package_id = $request->offer_id;
                $User_package->num_days = $request->num_day;
                $User_package->price = $request->price;
                $User_package->area = $request->area;
                $User_package->start_date = $request->start_date;
                $User_package->end_date = $date;

                $User_package->save();
            }

            if ($client) {
                // Mail::to($client->email)->send(new WelcomeEmail($client->name));
                return redirect()->route('clients.index', ['type' => $client->work])->with(['success', 'Created successfully']);

            } else {
                return redirect()->route('clients.index', ['type' => $client->work])->with(['error', 'Something wrong Please Try again later']);
            }
        } else {
            return redirect(url(Auth()->user()->user_type));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $client)
    {
        $this->authorize('checkType', [User::class, $client->work]);

        if (($client->work == 1 && in_array('show_client', app('User_permission'))) ||
            $client->work == 2 && in_array('show_resturant', app('User_permission')) ||
            $client->work == 3 && in_array('show_client_warehouse', app('User_permission')) ||
            $client->work == 4 && in_array('show_client_fulfillment', app('User_permission'))
        ) {

            $this->authorize('showCleintCompany', $client);
            $addresses = Address::where('user_id', $client->id)->get();
            $transactions = ClientTransactions::where('user_id', $client->id);
            // ->where(function ($query) {
            //     $query->where('debtor', '!=', 0)
            //           ->orWhere('creditor', '!=', 0);
            // });

            $alltransactions = $transactions->orderBy('id', 'desc')->paginate(200);
            $count_creditor = $transactions->sum('creditor');
            $count_debtor = $transactions->sum('debtor');

            $count_order_creditor = $transactions->whereNotNull('order_id')->sum('creditor');

            $count_order_debtor = $transactions->whereNotNull('order_id')->sum('debtor');

            return view('admin.clients.show', compact('client', 'addresses', 'count_creditor', 'count_debtor', 'count_order_creditor', 'count_order_debtor'));
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $client)
    {
        $this->authorize('checkType', [User::class, $client->work]);

        if (($client->work == 1 && in_array('edit_client', app('User_permission'))) ||
            $client->work == 2 && in_array('edit_resturant', app('User_permission')) ||
            $client->work == 3 && in_array('edit_client_warehouse', app('User_permission')) ||
            $client->work == 4 && in_array('show_client_fulfillment', app('User_permission'))

        ) {

            $this->authorize('editCleintCompany', $client);

            $zones = Zone::where('company_id', Auth()->user()->company_id)->where('type', 'city')->get();
            $statuses = Status::where('company_id', Auth()->user()->company_id)->orderBy('sort', 'ASC')->get();
 $cities = City::get();

            $Zone_accounts = Zone_account::where('user_id', $client->id)->get();
            if ($client->work == 3) {
                $sizes = Size::where('company_id', Auth()->user()->company_id)->get();
                $user_cost=UserCost::where('user_id',$client->id)->first();
                $user_status=UserStatus::where('user_id',$client->id)->first();

                if($user_cost==null)
                {
        
                    $user_cost = UserCost::create([
                        'user_id' => $client->id,
                        'pallet_in' => 0,
                        'pallet_out' => 0,
                        'packging_pallet' => 0,
                        'segregation_pallet' => 0,
                        'palletization' => 0,
                        'wooden_pallet' => 0,
                        'return_pallet' => 0,
                        'pallet_shipping' => 0,
                        
                    ]);
                }
                if($user_status==null)
                {
                    $defult_status=Status::where('company_id',Auth()->user()->company_id)->where('storehouse_appear',1)->first();
                    $user_status = UserStatus::create([
                        'user_id' => $client->id,
                        'pallet_in_status_id' => $defult_status->id,
                        'pallet_out_status_id' => $defult_status->id,
                        'packging_pallet_status_id' => $defult_status->id,
                        'segregation_pallet_status_id' => $defult_status->id,
                        'palletization_status_id' => $defult_status->id,
                        'wooden_pallet_status_id' => $defult_status->id,
                        'return_pallet_status_id' => $defult_status->id,
                        'pallet_shipping_status_id' => $defult_status->id,
                    ]);

                }
                return view('admin.clients.edit_warehouse', compact('client', 'statuses', 'cities', 'sizes',));
            }

            return view('admin.clients.edit', compact('client', 'statuses', 'cities', 'Zone_accounts', 'zones'));
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {

        $clientData = $request->all();
        $client = User::findOrFail($id);
        $this->authorize('checkType', [User::class, $client->work]);
// dd($request->password);
        if (($client->work == 1 && in_array('show_client', app('User_permission'))) ||
            $client->work == 2 && in_array('show_resturant', app('User_permission')) ||
            $client->work == 3 && in_array('show_client_warehouse', app('User_permission')) ||
            $client->work == 4 && in_array('show_client_fulfillment', app('User_permission'))) {
                if ($request->password != null) {
                $request->validate([
                    'password' => 'min:8|confirmed',
                ]);
                $clientData['password'] = bcrypt($request->password);
                if ($request->hasFile('Tax_certificate')) {
                    $Tax_certificate = 'avatar/client/'.$request->file('Tax_certificate')->hashName();
                    $uploaded = $request->file('Tax_certificate')->storeAs('public', $Tax_certificate);
                    if ($uploaded) {
                        $clientData['Tax_certificate'] = $Tax_certificate;
                    }
                }

                if ($request->hasFile('commercial_register')) {
                    $commercial_register = 'avatar/client/'.$request->file('commercial_register')->hashName();
                    $uploaded = $request->file('commercial_register')->storeAs('public', $commercial_register);
                    if ($uploaded) {
                        $clientData['commercial_register'] = $commercial_register;
                    }
                }

                if ($request->hasFile('signed_contract')) {
                    $signed_contract = 'avatar/client/'.$request->file('signed_contract')->hashName();
                    $uploaded = $request->file('signed_contract')->storeAs('public', $signed_contract);
                    if ($uploaded) {
                        $clientData['signed_contract'] = $signed_contract;
                    }
                }

                if ($request->hasFile('avatar')) {
                    $avatar = 'avatar/client'.$request->user_type.'/'.$request->file('avatar')->hashName();
                    $uploaded = $request->file('avatar')->storeAs('public', $avatar);
                    if ($uploaded) {
                        $clientData['avatar'] = $avatar;
                    }

                }
                $client->update($clientData);
            } else {
                $clientData['password'] = $client->password;
                if ($request->hasFile('Tax_certificate')) {
                    $Tax_certificate = 'avatar/client/'.$request->file('Tax_certificate')->hashName();
                    $uploaded = $request->file('Tax_certificate')->storeAs('public', $Tax_certificate);
                    if ($uploaded) {
                        $clientData['Tax_certificate'] = $Tax_certificate;
                    }
                }

                if ($request->hasFile('commercial_register')) {
                    $commercial_register = 'avatar/client/'.$request->file('commercial_register')->hashName();
                    $uploaded = $request->file('commercial_register')->storeAs('public', $commercial_register);
                    if ($uploaded) {
                        $clientData['commercial_register'] = $commercial_register;
                    }
                }

                if ($request->hasFile('signed_contract')) {
                    $signed_contract = 'avatar/client/'.$request->file('signed_contract')->hashName();
                    $uploaded = $request->file('signed_contract')->storeAs('public', $signed_contract);
                    if ($uploaded) {
                        $clientData['signed_contract'] = $signed_contract;
                    }
                }

                if ($request->hasFile('avatar')) {
                    $avatar = 'avatar/client'.$request->user_type.'/'.$request->file('avatar')->hashName();
                    $uploaded = $request->file('avatar')->storeAs('public', $avatar);
                    if ($uploaded) {
                        $clientData['avatar'] = $avatar;
                    }

                }
                $client->update($clientData);
            }
            if ($request->work == 4) {
                $user_cost = UserCost::where('user_id', $client->id)->first();
                $user_status = UserStatus::where('user_id', $client->id)->first();

                $user_cost->update([
                    'cost_inside_city' => $request->cost_inside_city,
                    'cost_outside_city' => $request->cost_outside_city,
                    'cost_reshipping' => $request->cost_reshipping,
                    'cost_reshipping_out_city' => $request->cost_reshipping_out_city,
                    'fees_cash_on_delivery' => $request->fees_cash_on_delivery,
                    'fees_cash_on_delivery_out_city' => $request->fees_cash_on_delivery_out_city,
                    'pickup_fees' => $request->pickup_fees,
                    'over_weight_per_kilo' => $request->over_weight_per_kilo,
                    'over_weight_per_kilo_outside' => $request->over_weight_per_kilo_outside,
                    'standard_weight' => $request->standard_weight,
                    'standard_weight_outside' => $request->standard_weight_outside,
                    'receive_palette' => $request->receive_palette,
                    'store_palette' => $request->store_palette,
                    'pallet_subscription_type' => $request->pallet_subscription_type,
                    'sort_by_suku' => $request->sort_by_suku,
                    'pick_process_package' => $request->pick_process_package,
                    'print_waybill' => $request->print_waybill,
                    'sort_by_city' => $request->sort_by_city,
                    'store_return_shipment' => $request->store_return_shipment,
                    'reprocess_return_shipment' => $request->reprocess_return_shipment,
                ]);

                $user_status->update([
                    'default_status_id' => $request->default_status_id,
                    'available_edit_status' => $request->available_edit_status,
                    'available_delete_status' => $request->available_delete_status,
                    'available_collect_order_status' => $request->available_collect_order_status,
                    'available_overweight_status' => $request->available_overweight_status,
                    'available_overweight_status_outside' => $request->available_overweight_status_outside,
                    'calc_cash_on_delivery_status_id' => $request->calc_cash_on_delivery_status_id,
                    'cost_calc_status_id_outside' => $request->cost_calc_status_id_outside,
                    'cost_calc_status_id' => $request->cost_calc_status_id,
                    'cost_reshipping_calc_status_id' => $request->cost_reshipping_calc_status_id,
                    'receive_palette_status_id' => $request->receive_palette_status_id,
                    'store_palette_status_id' => $request->store_palette_status_id,
                    'sort_by_skus_status_id' => $request->sort_by_skus_status_id,
                    'pick_process_package_status_id' => $request->pick_process_package_status_id,
                    'print_waybill_status_id' => $request->print_waybill_status_id,
                    'sort_by_city_status_id' => $request->sort_by_city_status_id,
                    'store_return_shipment_status_id' => $request->store_return_shipment_status_id,
                    'reprocess_return_shipment_status_id' => $request->reprocess_return_shipment_status_id,
                    'shortage_order_quantity_f_stock'=>$request->shortage_order_quantity_f_stock,
                    'restocking_order_quantity_to_stock'=>$request->restocking_order_quantity_to_stock,


                ]);
            }
            if($client->work==3)
            {
                $user_cost = UserCost::where('user_id', $client->id)->first();
                $user_status = UserStatus::where('user_id', $client->id)->first();
               
        
                    $user_cost->update([
                        'pallet_in' => $request->pallet_in,
                        'pallet_out' => $request->pallet_out,
                        'packging_pallet' => $request->packging_pallet,
                        'segregation_pallet' => $request->segregation_pallet,
                        'palletization' => $request->palletization,
                        'wooden_pallet' => $request->wooden_pallet,
                        'return_pallet' => $request->return_pallet,
                        'pallet_shipping' => $request->pallet_shipping,
                        
                    ]);
        
                    $user_status->update([
                        'pallet_in_status_id' => $request->pallet_in_status_id,
                        'pallet_out_status_id' => $request->pallet_out_status_id,
                        'packging_pallet_status_id' => $request->packging_pallet_status_id,
                        'segregation_pallet_status_id' => $request->segregation_pallet_status_id,
                        'palletization_status_id' => $request->palletization_status_id,
                        'wooden_pallet_status_id' => $request->wooden_pallet_status_id,
                        'return_pallet_status_id' => $request->return_pallet_status_id,
                        'pallet_shipping_status_id' => $request->pallet_shipping_status_id,
                    ]);
        
        
                
            }
            //
            if ($request->zone_id) {
                Zone_account::where('user_id', $client->id)->delete();
                foreach ($request->zone_id as $i => $zone) {
                    $zone_account = new Zone_account();
                    $zone_account->zone_id = $zone;
                    $zone_account->user_id = $client->id;
                    $zone_account->cost_inside_zone = $request->cost_inside_zone[$i];
                    $zone_account->cost_outside_zone = $request->cost_outside_zone[$i];
                    $zone_account->cost_reshipping_zone = $request->cost_reshipping_zone[$i];
                    $zone_account->cost_reshipping_out_zone = $request->cost_reshipping_out_zone[$i];
                    $zone_account->fees_cash_on_delivery_zone = $request->fees_cash_on_delivery_zone[$i];
                    $zone_account->fees_cash_on_delivery_out_zone = $request->fees_cash_on_delivery_out_zone[$i];
                    $zone_account->pickup_fees_zone = $request->pickup_fees_zone[$i];
                    $zone_account->over_weight_per_kilo_zone = $request->over_weight_per_kilo_zone[$i];
                    $zone_account->over_weight_per_kilo_outside_zone = $request->over_weight_per_kilo_outside_zone[$i];
                    $zone_account->standard_weight_zone = $request->standard_weight_zone[$i];
                    $zone_account->standard_weight_outside_zone = $request->standard_weight_outside_zone[$i];
                    $zone_account->save();
                }
            }

            if ($request->goods) {
                Client_good::where('user_id', $client->id)->delete();

                foreach ($request->goods as $good) {
                    $Client_good = new Client_good();
                    $Client_good->user_id = $client->id;
                    $Client_good->good_id = $good;
                    $Client_good->save();
                }
            }

            return redirect()->route('clients.index', ['type' => $client->work])->with(['success', trans('admin_message.updated_successfully')]);
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    public function balances(Request $request)
    {
        $this->authorize('checkType', [User::class, $request->type]);

        $type = $request->type;
        if (($request->type == 1 && in_array('show_balances', app('User_permission'))) ||
            $request->type == 2 && in_array('show_balance_res', app('User_permission')) ||
            $request->type == 3 && in_array('show_balance_warehouse', app('User_permission')) ||
            $request->type == 4 && in_array('show_balance_fulfillment', app('User_permission'))) {

            $clients = User::orderBy('id', 'desc')->where('work', $request->type)->where('company_id', Auth()->user()->company_id)->where('user_type', 'client')->paginate(15);

            $select_clients = User::orderBy('name', 'asc')->where('work', $request->type)->where('user_type', 'client')->where('company_id', Auth()->user()->company_id)->get();
            if (! empty($clients)) {
                foreach ($clients as $client) {
                    $transactions = ClientTransactions::where('user_id', $client->id);
                    $client->count_creditor = $transactions->sum('creditor');

                    $client->count_debtor = $transactions->sum('debtor');
                }

            }

            return view('admin.clients.balances', compact('clients', 'select_clients', 'type'));
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    public function transactions(Request $request, $id)
    {
       
        $from = $request->get('from');
        $to = $request->get('to');
        $client = User::orderBy('id', 'desc')->where('id', $id)->where('user_type', 'client')->first();
        if (($client->work == 1 && in_array('show_balances', app('User_permission'))) ||
            $client->work == 2 && in_array('show_balance_res', app('User_permission')) ||
            $client->work == 3 && in_array('show_balance_warehouse', app('User_permission')) ||
            $client->work == 4 && in_array('show_balance_fulfillment', app('User_permission'))) {
            if ($client) {
                switch ($request->input('action')) {
                    case 'export':
                        $file_name=$client->name.'_transactions.xlsx';
                        return Excel::download(new BalanceTransactionExport($client->id,$request),$file_name);                
                        break;
                }
                $transactions = ClientTransactions::where('user_id', $client->id)
                                    ->where(function ($query) {
                                        $query->where('debtor', '!=', 0)
                                            ->orWhere('creditor', '!=', 0);
                                    });

                $pallet_subscriptions = PaletteSubscription::whereHas('clientPackagesGoods', function ($query) use ($id) {
                                                    $query->where('client_id', $id);
                                                })->where('type', '!=' , 'receive_palette' )->orderBy('id', 'desc')->paginate(200);
                                                
                $pallet_recives = PaletteSubscription::whereHas('pickupOrder', function ($query) use ($id) {
                        $query->where('user_id', $id);
                    })->orderBy('id', 'desc')->paginate(200);

                if ($from != null && $to != null) {
                    $transactions = $transactions->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to);
                }
                // if($client->work == 2){
                //     $cod_transactions =  $transactions->where('transaction_type_id', 3)->orWhere('transaction_type_id', 4)->orderBy('id', 'desc')->paginate(50);


                //     $chipment_transactions =  $transactions->where('transaction_type_id','!=', 3)->orWhere('transaction_type_id', '!=',4)->orderBy('id', 'desc')->paginate(50);


                //     // dd($chipment_transactions);
                // }else{
                    $alltransactions = $transactions->orderBy('id', 'desc')->paginate(200);

                // }

                $count_creditor = $transactions->sum('creditor') + $pallet_subscriptions->sum('cost') + $pallet_recives->sum('cost');
                $count_debtor = $transactions->sum('debtor');

                $count_order_creditor = $transactions->whereNotNull('order_id')->sum('creditor');

                $count_order_debtor = $transactions->whereNotNull('order_id')->sum('debtor');
                // if($client->work == 2){
                //     return view('admin.clients.balance-transactions', compact('cod_transactions', 'chipment_transactions','pallet_subscriptions', 'pallet_recives', 'client', 'from', 'to', 'count_debtor', 'count_creditor', 'count_order_debtor', 'count_order_creditor'));
                // }else{
                    return view('admin.clients.balance-transactions', compact('alltransactions','pallet_subscriptions', 'pallet_recives', 'client', 'from', 'to', 'count_debtor', 'count_creditor', 'count_order_debtor', 'count_order_creditor'));

                // }

            } else {
                abort(404);
            }
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    public function getFilteredData(Request $request)
    {
        // Get the tab parameter from the request
        $tab = $request->input('tab');

        // Define the type_id based on the selected tab
        switch ($tab) {
            case '#all':
                $type_id = 1;
                break;
            case '#cod':
                $type_id = 2;
                break;
            case '#costs':
                $type_id = 3;
                break;
            case '#deposit':
                $type_id = 4;
                break;
        }
        $filteredData = ClientTransactions::where('user_id', $request->id)->where('type_id', $type_id)->get();

        return response()->json($filteredData);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('checkType', [User::class, $user->work]);

        if (($user->work == 1 && in_array('delete_client', app('User_permission'))) ||
            $user->work == 2 && in_array('delete_resturant', app('User_permission')) ||
            $user->work == 3 && in_array('delete_client_warehouse', app('User_permission')) ||
            $user->work == 4 && in_array('delete_client_fulfillment', app('User_permission'))) {
            $this->authorize('deleteCleintCompany', $user);

            if ($user->company_id != Auth()->user()->company_id) {
                return redirect()->back()->with('error', 'لا يوجد هذا العميل   فى حسابك');
            }
            User::findOrFail($id)->delete();
            Order::where('user_id', $id)->delete();
            $notification = [
                'message' => '<h3>Delete Successfully</h3>',
                'alert-type' => 'success',
            ];

            return back()->with($notification);
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    public function transactionStore(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'description' => 'required',
        ]);

        $client = User::find($request->user_id);
        $this->authorize('checkType', [User::class, $client->work]);
        if ($this->testPermission_add($client) == 'yes') {
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
        } else {
            return redirect(url(Auth()->user()->user_type));
        }

    }

    public function transactionDestroy($id)
    {
        $Transactions = ClientTransactions::findOrFail($id);
        $client = User::findOrFail($Transactions->user_id);
        $this->authorize('checkType', [User::class, $client->work]);

        if ($this->testPermission_destroy($client) == 'yes') {
            ClientTransactions::findOrFail($id)->delete();
            $notification = [
                'message' => '<h3>Delete Successfully</h3>',
                'alert-type' => 'success',
            ];

            return back()->with($notification);
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }

    public function subscriptionDestroy($id)
    {
        $subscription = PaletteSubscription::findOrFail($id);
        $client = User::findOrFail($subscription->clientPackagesGoods->client_id);
        $this->authorize('checkType', [User::class, $client->work]);

        if ($this->testPermission_destroy($client) == 'yes') {
            PaletteSubscription::findOrFail($id)->delete();
            $notification = [
                'message' => '<h3>Delete Successfully</h3>',
                'alert-type' => 'success',
            ];

            return back()->with($notification);
        } else {
            return redirect(url(Auth()->user()->user_type));
        }
    }


    public function api(Request $request)
    {

        if (($request->type == 1 && in_array('add_client', app('User_permission'))) ||
            $request->type == 2 && in_array('add_resturant', app('User_permission')) ||
            $request->type == 3 && in_array('add_client_warehouse', app('User_permission')) ||
            $request->type == 4 && in_array('add_client_fulfillment', app('User_permission'))
        ) {
            $work = $request->type;
            $clients = User::where('company_id', Auth()->user()->company_id)->where('work', $request->type)->where('user_type', 'client')
                ->where('api_token', '=', null)
                ->get();

            $apiList = User::where('company_id', Auth()->user()->company_id)->where('work', $request->type)->where('user_type', 'client')
                ->where('api_token', '!=', null)
                ->paginate(15);

            return view('admin.clients.api', compact('clients', 'apiList', 'work'));
        }
    }

    public function apiStore(Request $request)
    {
        $id = $request->user_id;
        $client = User::findOrFail($id);
        if ($client) {
            User::where('id', $id)->update([
                'api_token' => $this->apiToken,
                'domain' => $request->domain,
            ]);
            $notification = [
                'message' => '<h3>Save Successfully</h3>',
                'alert-type' => 'success',
            ];
        } else {
            $notification = [
                'message' => '<h3>Client Not Exist</h3>',
                'alert-type' => 'error',
            ];
        }

        return back()->with($notification);

    }

    public function apiDestroy($id)
    {
        User::where('id', $id)->update([
            'api_token' => null,
            'domain' => null,
        ]);
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'info',
        ];

        return back()->with($notification);
    }

    public function addresses($id)
    {
        $addresses = Address::where('user_id', $id)->get();

        return view('admin.clients.addresses.index', compact('addresses', 'id'));

    }

    //
    public function address_create($id)
    {
            $cities = City::get();

        return view('admin.clients.addresses.add', compact('cities', 'id'));
    }

    public function address_store(Request $request)
    {
        $request->validate([
            'city_id' => 'required|numeric',
            'neighborhood_id' => 'numeric',
            'address' => 'required|min:3|max:100',
            'description' => 'max:200',
            'phone' => 'nullable|numeric|min:10|starts_with:05',
        ]);

        $user = User::where('id', $request->id)->first();
        if ($request['main_address'] == 1) {
            Address::where('user_id', $user->id)->update(['main_address' => 0]);
        }

        $user->addresses()->create($request->all());
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('clients.index', ['type' => $user->work])->with($notification);
    }

    public function address_edit($id)
    {
        $address = Address::findOrFail($id);
            $cities = City::get();
        $region = Neighborhood::where('id', $address->neighborhood_id)->first();

        return view('admin.clients.addresses.edit', compact('cities', 'address', 'region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Address_update(Request $request, $id)
    {
        $request->validate([
            'city_id' => 'required|numeric',
            'neighborhood_id' => 'numeric',
            'address' => 'required|min:3|max:100',
            'description' => 'max:200',
            'phone' => 'nullable|numeric|min:10|starts_with:05',
        ]);

        $address = Address::findOrFail($id);
        $user = User::where('id', $address->user_id)->first();
        if ($request['main_address'] == 1) {
            Address::where('user_id', $user->id)->update(['main_address' => 0]);
        }

        if ($request->map_or_link == 'link') {
            $address->update($request->all());
            $address->update([

                'longitude' => null,
                'latitude' => null,
            ]);
        } elseif ($request->map_or_link == 'map') {
            $address->update($request->all());
            $address->update(['link' => null]);
        }

        return redirect()->route('clients.index', ['type' => $user->work])->with('success', 'Address updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function address_delete($id)
    {
        Address::findOrFail($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    private function testPermission_destroy($client)
    {
        if (($client->user_type == 'client' && $client->work == 1 && in_array('delete_balances', app('User_permission'))) ||
            $client->user_type == 'client' && $client->work == 2 && in_array('delete_balance_res', app('User_permission')) ||
            $client->user_type == 'client' && $client->work == 3 && in_array('delete_balance_warehouse', app('User_permission')) ||
            $client->user_type == 'client' && $client->work == 4 && in_array('delete_balance_fulfillment', app('User_permission'))) {
            return 'yes';
        } elseif (($client->user_type == 'delegate' && $client->work == 1 && in_array('delete_balance_delegate', app('User_permission'))) ||
        $client->user_type == 'delegate' && $client->work == 2 && in_array('delete_balance_delegate_res', app('User_permission')) ||
            ($client->work == 3 && $client->user_type == 'delegate') && in_array('delete_balance_delegate_res', app('User_permission')) && in_array('delete_balance_delegate', app('User_permission'))) {
            return 'yes';

        } elseif (($client->user_type == 'service_provider' && in_array('delete_balance_service_provider', app('User_permission')))) {
            return 'yes';

        } else {
            return 'no';
        }

    }

    private function testPermission_add($client)
    {
        if (($client->user_type == 'client' && $client->work == 1 && in_array('add_balances', app('User_permission'))) ||
            $client->user_type == 'client' && $client->work == 2 && in_array('add_balance_res', app('User_permission')) ||
            $client->user_type == 'client' && $client->work == 4 && in_array('add_balance_fulfillment', app('User_permission')) ||

            $client->user_type == 'client' && $client->work == 3 && in_array('add_balance_warehouse', app('User_permission'))) {
            return 'yes';
        } elseif (($client->user_type == 'delegate' && $client->work == 1 && in_array('add_balance_delegate', app('User_permission'))) ||
        $client->user_type == 'delegate' && $client->work == 2 && in_array('add_balance_delegate_res', app('User_permission')) ||
            ($client->work == 3 && $client->user_type == 'delegate') && in_array('add_balance_delegate_res', app('User_permission')) && in_array('add_balance_delegate', app('User_permission'))) {
            return 'yes';

        } elseif (($client->user_type == 'service_provider' && in_array('add_balance_service_provider', app('User_permission')))) {
            return 'yes';

        } else {
            return 'no';
        }

    }

 


}
