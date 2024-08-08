<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\WhatWeDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WhatWeDoController extends Controller
{
    public function __construct()
    {
       
    }

    public function index()
    {
        $whatWeDo = WhatWeDo::get();

        return view('super_admin.website.what-we-do.index', compact('whatWeDo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('super_admin.website.what-we-do.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png',
        ]);

        $whatWeDoData = $request->all();
        if ($request->hasFile('image')) {
            $image = 'website/what-we-do/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $whatWeDoData['icon_class'] = $image;
            }
        }

        $whatWeDo = WhatWeDo::create($whatWeDoData);

        if ($whatWeDo) {
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

        return redirect()->route('what-we-do.index')->with($notification);
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
    public function edit(WhatWeDo $whatWeDo)
    {
        return view('super_admin.website.what-we-do.edit', compact('whatWeDo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $whatWeDo = WhatWeDo::findOrFail($id);

        $whatWeDoData = $request->all();

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$whatWeDo->icon_class);
            $image = 'website/what-we-do/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $whatWeDoData['icon_class'] = $image;
            }
        }
        if ($whatWeDo->update($whatWeDoData)) {
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

        return redirect()->route('what-we-do.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $whatWeDo = WhatWeDo::findOrFail($id);
        if ($whatWeDo) {
            Storage::delete('public/'.$whatWeDo->icon_class);
            $whatWeDo->delete();
            $notification = [
                'message' => '<h3>Delete Successfully</h3>',
                'alert-type' => 'success',
            ];
        }

        return back()->with($notification);
    }
}
