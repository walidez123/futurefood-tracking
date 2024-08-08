<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Good;
use Illuminate\Http\Request;

class QRController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $goods = Good::where('company_id', Auth()->user()->company_id)->where('client_id', Auth()->user()->id)->get();

        return view('client.QR.index', compact('goods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
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

            return view('client.QR.QRprint', compact('all_good', 'number', 'type'));
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
