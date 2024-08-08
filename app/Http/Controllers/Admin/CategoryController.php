<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_category', ['only' => 'index', 'show']);
        $this->middleware('permission:add_category', ['only' => 'create', 'store']);
        $this->middleware('permission:edit_category', ['only' => 'edit', 'update']);
        $this->middleware('permission:delete_category', ['only' => 'destroy']);
    }

    public function index()
    {
        $categories = Category::where('company_id', Auth()->user()->company_id)->get();

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            // 'slug'       => 'required|unique:categories',
        ]);
        Category::create($request->all());
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('categories.index')->with($notification);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'slug' => 'required|unique:categories,slug,'.$id,
        ]);
        $category = Category::findOrFail($id);
        $category->update($request->all());
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('categories.index')->with($notification);
    }

    public function destroy(Request $request, $id)
    {
        // dd($request->all(), $id);
        $category = Category::findOrFail($id);
        $selectedCategory = $request->category_id;
        $category->posts()->update(['category_id' => $selectedCategory]);
        $category->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'info',
        ];

        return redirect()->route('categories.index')->with($notification);
    }

    public function confirm($id)
    {
        $categories = Category::whereNotIn('id', [$id])->get();

        return view('admin.category.confirm-delete', compact('categories', 'id'));
    }
}
