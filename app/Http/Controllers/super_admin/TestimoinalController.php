<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Testimoinal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoinalController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $sliders = Testimoinal::get();

        return view('super_admin.website.Testimoinal.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('super_admin.website.Testimoinal.add');
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
            $image = 'website/Testimoinal/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $sliderData['image'] = $image;
            }
        }
        $slider = Testimoinal::create($sliderData);

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

        return redirect()->route('testimoinals.index')->with($notification);
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
        $slider = Testimoinal::findorfail($id);

        return view('super_admin.website.Testimoinal.edit', compact('slider'));
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
        $slider = Testimoinal::findOrFail($id);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$slider->image);
            $image = 'website/Testimoinal/'.$request->file('image')->hashName();
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

        return redirect()->route('testimoinals.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Testimoinal::findOrFail($id);
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
