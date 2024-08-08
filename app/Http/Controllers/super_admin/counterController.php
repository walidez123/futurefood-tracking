<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class counterController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:show_slider', ['only'=>'index', 'show']);
        // $this->middleware('permission:add_slider', ['only'=>'create', 'store']);
        // $this->middleware('permission:edit_slider', ['only'=>'edit', 'update']);
        // $this->middleware('permission:delete_slider', ['only'=>'destroy']);
    }

    public function index()
    {
        $sliders = Counter::get();

        return view('super_admin.website.Counter.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('super_admin.website.Counter.add');
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
            'count' => 'required',
            'image' => 'mimes:jpeg,jpg,png',

        ]);

        $sliderData = $request->all();
        if ($request->hasFile('image')) {
            $image = 'website/counter/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $sliderData['image'] = $image;
            }
        }

        $slider = Counter::create($sliderData);

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

        return redirect()->route('counters.index')->with($notification);
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
        $slider = Counter::findorfail($id);

        return view('super_admin.website.Counter.edit', compact('slider'));
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
        $slider = Counter::findOrFail($id);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$slider->image);
            $image = 'website/counter/'.$request->file('image')->hashName();
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

        return redirect()->route('counters.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Counter::findOrFail($id);
        $slider->delete();

        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
