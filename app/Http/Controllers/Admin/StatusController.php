<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyBlinkStatus;
use App\Models\CompanyFoodicsStatus;
use App\Models\CompanySallaStatus;
use App\Models\CompanyZidStatus;
use App\Models\CompanyAymakanStatus;
use App\Models\CompanyProviderStatuses;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    //delegate_appear
    public function __construct()
    {
        $this->middleware('permission:show_status', ['only' => 'index', 'show', 'createFoodicsStatus']);
        $this->middleware('permission:add_status', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_status', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_status', ['only' => 'destroy']);
    }

    public function index()
    {
        $statuses_company = Status::where('company_id', Auth()->user()->company_id)->orderBy('sort', 'ASC')->paginate(25);

        return view('admin.statuses.index', compact('statuses_company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Status::where('company_id', Auth()->user()->company_id)->orderBy('sort', 'DESC')->first();
        if ($status != null) {
            $sort = $status->sort;

        } else {
            $sort = 1;
        }

        return view('admin.statuses.add', compact('sort'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'title_ar' => 'required',

        ]);
        $status_request = $request->all();

        Status::create($status_request);
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('statuses.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        if ($status->company_id != Auth()->user()->company_id) {
            return redirect()->back()->with('error', 'لا توجد هذه الحالة فى حسابك');
        }

        return view('admin.statuses.edit', compact('status'));
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
            'title' => 'required',
            'title_ar' => 'required',
        ]);
        $status = Status::findOrFail($id);
        if ($status->company_id != Auth()->user()->company_id) {
            return redirect()->back()->with('error', 'لا توجد هذه الحالة فى حسابك');
        }
        $status->update($request->all());
        if ($request->otp_send_code == 0) {
            $status->update(['otp_status_send' => null]);
        }
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('statuses.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Status::findOrFail($id);

        if ($status->company_id != Auth()->user()->company_id) {
            return redirect()->back()->with('error', 'لا توجد هذه الحالة فى حسابك');
        }
        Status::findOrFail($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    public function change_delegate_appear(Request $request)
    {
        $id = $request->id;
        $data = Status::findOrFail($id);
        if ($data->company_id != Auth()->user()->company_id) {
            return redirect()->back()->with('error', 'لا توجد هذه الحالة فى حسابك');
        }
        if ($data != null) {
            if ($data->delegate_appear == 0) {
                $data->delegate_appear = 1;
            } else {
                $data->delegate_appear = 0;
            }
            $data->save();

            return $data->delegate_appear;
        } else {
            return 'error';
        }

    }

    public function change_client_appear(Request $request)
    {
        $id = $request->id;
        $data = Status::findOrFail($id);
        if ($data->company_id != Auth()->user()->company_id) {
            return redirect()->back()->with('error', 'لا توجد هذه الحالة فى حسابك');
        }
        if ($data != null) {
            if ($data->client_appear == 0) {
                $data->client_appear = 1;
            } else {
                $data->client_appear = 0;
            }
            $data->save();

            return $data->client_appear;
        } else {
            return 'error';
        }

    }

    public function change_restaurant_appear(Request $request)
    {
        $id = $request->id;
        $data = Status::findOrFail($id);
        if ($data->company_id != Auth()->user()->company_id) {
            return redirect()->back()->with('error', 'لا توجد هذه الحالة فى حسابك');
        }
        if ($data != null) {
            if ($data->restaurant_appear == 0) {
                $data->restaurant_appear = 1;
            } else {
                $data->restaurant_appear = 0;
            }
            $data->save();

            return $data->restaurant_appear;
        } else {
            return 'error';
        }

    }

    public function change_shop_appear(Request $request)
    {
        $id = $request->id;
        $data = Status::findOrFail($id);
        if ($data->company_id != Auth()->user()->company_id) {
            return redirect()->back()->with('error', 'لا توجد هذه الحالة فى حسابك');
        }
        if ($data != null) {
            if ($data->shop_appear == 0) {
                $data->shop_appear = 1;
            } else {
                $data->shop_appear = 0;
            }
            $data->save();

            return $data->shop_appear;
        } else {
            return 'error';
        }

    }

    public function change_storehouse_appear(Request $request)
    {
        $id = $request->id;
        $data = Status::findOrFail($id);
        if ($data->company_id != Auth()->user()->company_id) {
            return redirect()->back()->with('error', 'لا توجد هذه الحالة فى حسابك');
        }
        if ($data != null) {
            if ($data->storehouse_appear == 0) {
                $data->storehouse_appear = 1;
            } else {
                $data->storehouse_appear = 0;
            }
            $data->save();

            return $data->storehouse_appear;
        } else {
            return 'error';
        }

    }

    public function change_fulfillment_appear(Request $request)
    {
        $id = $request->id;
        $data = Status::findOrFail($id);
        if ($data->company_id != Auth()->user()->company_id) {
            return redirect()->back()->with('error', 'لا توجد هذه الحالة فى حسابك');
        }
        if ($data != null) {
            if ($data->fulfillment_appear == 0) {
                $data->fulfillment_appear = 1;
            } else {
                $data->fulfillment_appear = 0;
            }
            $data->save();

            return $data->fulfillment_appear;
        } else {
            return 'error';
        }

    }

    public function change_user_appear(Request $request)
    {
        $id = $request->id;
        $data = Status::findOrFail($id);
        if ($data->company_id != Auth()->user()->company_id) {
            return redirect()->back()->with('error', 'لا توجد هذه الحالة فى حسابك');
        }
        if ($data != null) {
            if ($data->user_appear == 0) {
                $data->user_appear = 1;
            } else {
                $data->user_appear = 0;
            }
            $data->save();

            return $data->user_appear;
        } else {
            return 'error';
        }

    }

    public function createFoodicsStatus()
    {
        $statuses = Status::where('company_id', Auth()->user()->company_id)->orderBy('sort', 'ASC')->get();
        $foodics_statuses = CompanyFoodicsStatus::where('company_id', Auth()->user()->company_id)->first();
        $blink_statuses = CompanyBlinkStatus::where('company_id', Auth()->user()->company_id)->first();
        $salla_statuses = CompanySallaStatus::where('company_id', Auth()->user()->company_id)->first();
        $zid_statuses = CompanyZidStatus::where('company_id', Auth()->user()->company_id)->first();
        $aymakan_statuses = CompanyAymakanStatus::where('company_id', Auth()->user()->company_id)->first();
        $smb_statuses = CompanyProviderStatuses::where('company_id',  Auth()->user()->company_id)->where('provider_name', 'smb')->first();

        return view('admin.statuses.partial_statuses.add', compact('statuses', 'foodics_statuses', 
                                                                    'blink_statuses', 'salla_statuses', 
                                                                    'zid_statuses', 'aymakan_statuses', 'smb_statuses'));
    }

    public function storeFoodicsStatuses(Request $request)
    {
        $request->validate([
            'new_order_id' => 'required',
            'assigned_id' => 'required',
            'en_route_id' => 'required',
            'delivered_id' => 'required',
            'closed_id' => 'required',

        ]);
        $status_request = $request->all();

        $foodics_statuses = CompanyFoodicsStatus::where('company_id', Auth()->user()->company_id)->first();

        if ($foodics_statuses) {
            $updated = $foodics_statuses->update($status_request);

            return redirect()->route('foodics_statuses.show')->with('success', 'Updated successfully');
        } else {
            $status_request = $request->all();

            $created = CompanyFoodicsStatus::create($status_request);

            if ($created) {
                return redirect()->route('foodics_statuses.show')->with('success', 'Updated successfully');
            } else {
                return redirect()->route('foodics_statuses.show')->with('error', 'Something went wrong!');
            }

        }

    }

    public function storeBlinkStatuses(Request $request)
    {
        $request->validate([
            'new_order_id' => 'required',
            'assigned_id' => 'required',
            'en_route_id' => 'required',
            'delivered_id' => 'required',
            'closed_id' => 'required',

        ]);

        $blink_statuses = CompanyBlinkStatus::where('company_id', Auth()->user()->company_id)->first();
        $status_request = $request->all();

        if ($blink_statuses) {
            $updated = $blink_statuses->update($status_request);

            return redirect()->back()->with('success', 'Updated successfully');
        } else {
            $status_request = $request->all();

            $created = CompanyBlinkStatus::create($status_request);

            if ($created) {
                return redirect()->back()->with('success', 'Updated successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }

        }

    }
    // storeSallaStatuses

    public function storeSallaStatuses(Request $request)
    {
        $request->validate([
            'new_order_id' => 'required',
            'assigned_id' => 'required',
            'en_route_id' => 'required',
            'delivered_id' => 'required',
            'closed_id' => 'required',

        ]);

        $salla_statuses = CompanySallaStatus::where('company_id', Auth()->user()->company_id)->first();
        $status_request = $request->all();

        if ($salla_statuses) {
            $updated = $salla_statuses->update($status_request);

            return redirect()->back()->with('success', 'Updated successfully');
        } else {
            $status_request = $request->all();

            $created = CompanySallaStatus::create($status_request);

            if ($created) {
                return redirect()->back()->with('success', 'Updated successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }

        }
    }

    public function storeZidStatuses(Request $request)
    {
        $request->validate([
            'new_order_id' => 'required',
            'assigned_id' => 'required',
            'en_route_id' => 'required',
            'delivered_id' => 'required',
            'closed_id' => 'required',

        ]);

        $zid_statuses = CompanyZidStatus::where('company_id', Auth()->user()->company_id)->first();
        $status_request = $request->all();

        if ($zid_statuses) {
            $updated = $zid_statuses->update($status_request);

            return redirect()->back()->with('success', 'Updated successfully');
        } else {
            $status_request = $request->all();

            $created = CompanyZidStatus::create($status_request);

            if ($created) {
                return redirect()->back()->with('success', 'Updated successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }

        }
    }

    public function storeAymakanStatuses(Request $request)
    {
        $request->validate([
            'new_order_id' => 'required',
            'assigned_id' => 'required',
            'en_route_id' => 'required',
            'delivered_id' => 'required',
            'pending_id' => 'required',
            'delayed_id' => 'required',
            'closed_id' => 'required',

        ]);

        $aymakan_statuses = CompanyAymakanStatus::where('company_id', Auth()->user()->company_id)->first();
        $status_request = $request->all();

        if ($aymakan_statuses) {
            $updated = $aymakan_statuses->update($status_request);

            return redirect()->back()->with('success', 'Updated successfully');
        } else {
            $status_request = $request->all();

            $created = CompanyAymakanStatus::create($status_request);

            if ($created) {
                return redirect()->back()->with('success', 'Updated successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }

        }
    }


    public function storeProviderStatuses(Request $request)
    {
        // Validation rules
        $request->validate([
            'provider_name'  => 'required',
            'new_order_id' => 'required',
            'assigned_id' => 'required',
            'en_route_id' => 'required',
            'delivered_id' => 'nullable',
            'closed_id' => 'required',
            'pending_id' => 'nullable',
            'delayed_id' => 'nullable',
            'charged_id' => 'nullable',
            'returned_id' => 'nullable',
        ]);
    
        // Get the authenticated user's company ID
        $company_id = Auth()->user()->company_id;
    
        // Fetch the existing provider statuses for the specified company and provider
        $provider_statuses = CompanyProviderStatuses::where('company_id', $company_id)
                                                    ->where('provider_name', $request->provider_name)
                                                    ->first();
    
        // Prepare the request data, ensuring the company_id is included
        $status_request = $request->all();
        $status_request['company_id'] = $company_id;
    
        // Logging the request data for debugging
        \Log::info('Status Request Data: ', $status_request);
    
        // Update or create the provider statuses record
        if ($provider_statuses) {
            $updated = $provider_statuses->update($status_request);
    
            // Logging the update result
            \Log::info('Update Result: ', ['updated' => $updated]);
    
            return redirect()->back()->with('success', 'Updated successfully');
        } else {
            $created = CompanyProviderStatuses::create($status_request);
    
            // Logging the creation result
            \Log::info('Creation Result: ', ['created' => $created]);
    
            if ($created) {
                return redirect()->back()->with('success', 'Created successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        }
    }
}
