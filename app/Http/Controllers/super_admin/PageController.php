<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function __construct()
    {
       
    }

    public function index()
    {
        $pages = Post::where('post_type', 'page')->get();

        return view('super_admin.website.page.index', compact('pages'));
    }

    public function create()
    {

        return view('super_admin.website.page.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'slug' => 'required|unique:posts',
        ]);

        $pageData = $request->all();
        $pageData['post_type'] = 'page';

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png',
            ]);
            $image = 'website/page/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $pageData['image'] = $image;
            }
        }
        $request->user()->posts()->create($pageData);
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('pages.index')->with($notification);
    }

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
        $page = Post::findOrFail($id);

        return view('super_admin.website.page.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'slug' => 'required|unique:posts,slug,'.$id,
        ]);
        $pageData = $request->all();
        $page = Post::findOrFail($id);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$page->image);
            $image = 'website/page/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $pageData['image'] = $image;
            }
        }
        if ($page->update($pageData)) {
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

        return redirect()->route('pages.index')->with($notification);
    }

    public function destroy($id)
    {
        $page = Post::findOrFail($id);
        $delete = Storage::delete('public/'.$page->image);
        $page->delete();

        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
