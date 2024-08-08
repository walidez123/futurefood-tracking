<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\PartnerCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    
    public function index()
    {
        $partners = Partner::get();

        return view('super_admin.website.partner.index', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PartnerCategory::get();

        return view('super_admin.website.partner.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png',
        ]);

        $sliderData = $request->all();
        if ($request->hasFile('image')) {
            $image = 'website/client/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $sliderData['image'] = $image;
            }
        }
        $slider = Partner::create($sliderData);

        if ($slider) {
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

        return redirect()->route('partners.index')->with($notification);
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
        $partner = Partner::findorfail($id);
        $categories = PartnerCategory::get();


        return view('super_admin.website.partner.edit', compact('partner', 'categories'));
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
        $slider = Partner::findOrFail($id);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$slider->image);
            $image = 'website/client/'.$request->file('image')->hashName();
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

        return redirect()->route('partners.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Partner::findOrFail($id);
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
