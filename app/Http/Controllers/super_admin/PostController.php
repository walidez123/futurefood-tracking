<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
       
    }

    public function index()
    {
        $posts = Post::where('post_type', 'post')->get();

        return view('super_admin.website.post.index', compact('posts'));
    }

    public function create()
    {

        $categories = Category::get();

        return view('super_admin.website.post.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'slug' => 'required|unique:posts',
        ]);

        $postData = $request->all();
        $postData['post_type'] = 'post';

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png',
            ]);
            $image = 'website/post/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $postData['image'] = $image;
            }
        }
        $request->user()->posts()->create($postData);
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('posts.index')->with($notification);
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
        $post = Post::findOrFail($id);
        $categories = Category::get();

        return view('super_admin.website.post.edit', compact('categories', 'post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'slug' => 'required|unique:posts,slug,'.$id,
        ]);
        $postData = $request->all();
        $post = Post::findOrFail($id);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$post->image);
            $image = 'website/post/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $postData['image'] = $image;
            }
        }
        if ($post->update($postData)) {
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

        return redirect()->route('posts.index')->with($notification);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $delete = Storage::delete('public/'.$post->image);
        $post->delete();

        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
