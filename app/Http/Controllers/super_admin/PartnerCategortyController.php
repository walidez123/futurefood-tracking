<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PartnerCategortyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partner_categories = PartnerCategory::get();

        return view('super_admin.website.partner_categories.index', compact('partner_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.website.partner_categories.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $image = 'website/client/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $data['image'] = $image;
            }
        }
        $created = PartnerCategory::create($data);

        if ($created) {
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

        return redirect()->route('partner-categories.index')->with($notification);
    }


    /**
     * Display the specified resource.
     */
    public function show(PartnerCategory $partnerCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $partner = PartnerCategory::findorfail($id);

        return view('super_admin.website.partner_categories.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sliderData = $request->all();
        $slider = PartnerCategory::findOrFail($id);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$slider->image);
            $image = 'website/partner/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $sliderData['image'] = $image;
            }
        }
        if ($slider->update($sliderData)) {
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

        return redirect()->route('partner-categories.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = PartnerCategory::findOrFail($id);
        $delete = Storage::delete('public/'.$slider->image);
        if ($delete) {
            $slider->delete();
        }
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
