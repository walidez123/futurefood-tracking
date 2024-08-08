<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::paginate(25);
        return view('super_admin.provinces.index', compact('provinces'));
    }

    public function create()
    {
        return view('super_admin.provinces.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Province::create($request->all());

        return redirect()->route('provinces.index')->with('success', 'Province created successfully.');
    }      

    public function edit(Province $province)
    {
        return view('super_admin.provinces.edit', compact('province'));
    }

    public function update(Request $request, Province $province)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $province->update($request->all());

        return redirect()->route('provinces.index')->with('success', 'Province updated successfully.');
    }

    public function destroy($id)
    {
        $province = Province::findOrFail($id);

        Province::findOrFail($id)->delete();

        return redirect()->route('provinces.index')->with('success', 'Province deleted successfully.');
    }
}
