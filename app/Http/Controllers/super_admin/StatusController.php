<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function __construct()
    {
       
    }

    public function index()
    {
        $statuses = Status::where('company_id', null)->paginate(25);

        return view('super_admin.statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('super_admin.statuses.add');
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
        ]);
        Status::create($request->all());
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('defult_status.index')->with($notification);
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
    public function edit($id)
    {
        $status = Status::find($id);

        return view('super_admin.statuses.edit', compact('status'));
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
        ]);
        $status = Status::findOrFail($id);
        if ($status->company_id != Auth()->user()->company_id) {
            return redirect()->back()->with('error', 'لا توجد هذه الحالة فى حسابك');
        }
        $status->update($request->all());
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('defult_status.index')->with($notification);
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
}
