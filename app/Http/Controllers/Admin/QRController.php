<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Good;
use App\Models\Warehouse_branche;
use App\Models\Warehouse_content;
use Illuminate\Http\Request;

class QRController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:QR_print', ['only' => 'index', 'store']);
        // $this->middleware('permission:add_city', ['only'=>'create', 'store']);
        // $this->middleware('permission:edit_city', ['only'=>'edit', 'update']);
        // $this->middleware('permission:delete_city', ['only'=>'destroy']);
    }

    public function index()
    {
        $goods = Good::where('company_id', Auth()->user()->company_id)->where('client_id', null)->get();
        $warhouse = Warehouse_branche::where('company_id', Auth()->user()->company_id)->get();

        return view('admin.QR.index', compact('goods', 'warhouse'));
    }

    public function index2()
    {
        return view('admin.QR.index2');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type = $request->type;
        // dd($request->good_id);
        if (isset($request->good_id) && $request->good_id != null) {
            foreach ($request->good_id as $i => $good) {
                $all_good[$i] = Good::where('id', $good)->pluck('SKUS')->toArray();

            }
            $number = $request->number;

            return view('admin.QR.QRprint', compact('all_good', 'number', 'type'));
        }

        if (isset($request->type_id) && $request->type_id != null && $request->all_content != 'on') {
            foreach ($request->type_id as $i => $type_id) {
                $warahouse[$i] = Warehouse_content::where('id', $type_id)->pluck('title')->toArray();

            }
            $number = $request->number;

            return view('admin.QR.QRprint', compact('warahouse', 'number', 'type'));
        }
        if (isset($request->all_content) && $request->all_content == 'on' && isset($request->type_id) && $request->type_id != null) {
            foreach ($request->type_id as $i => $type_id) {
                $warahous = Warehouse_content::Where('id', $type_id)->first();
                if ($warahous->type == 'stand') {
                    $content[$i] = Warehouse_content::Where('stand_id', $type_id)->get();

                }
                if ($warahous->type == 'floor') {
                    $content[$i] = Warehouse_content::Where('floor_id', $type_id)->get();

                }

                $warahouse[$i] = Warehouse_content::Where('id', $type_id)->pluck('title')->toArray();

            }
            $number = $request->number;

            return view('admin.QR.QRprint', compact('warahouse', 'number', 'type', 'content'));

        }

        return redirect()->back()->with('success', 'Qr created successfully');
    }

    //
    public function store2(Request $request)
    {
        $start_number = $request->start_number;
        $type = $request->type;
        $number = $request->number;

        // dd($request->good_id);
        return view('admin.QR.QRprint2', compact('start_number', 'number', 'type'));

    }

    //
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
    public function edit(Good $Good)
    {

        $Categories = Category::all();

        return view('admin.goods.edit', compact('Good', 'Categories'));
    }

    public function Qrcode($id)
    {
        $Good = Good::find($id);

        return view('admin.goods.Qrcode', compact('Good'));

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
        $Good = Good::findOrFail($id);

        $Good->update($request->all());
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('goods.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Good::findOrFail($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
