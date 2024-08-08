<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebSettingController extends Controller
{
    public function __construct()
    {
    }

    public function edit()
    {
        $settings = WebSetting::where('id', 1)->first();

        return view('super_admin.website.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = WebSetting::where('id', 1)->first();
        $settingsData = $request->all();
        if ($request->hasFile('logo')) {
            $request->validate([
                'logo' => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$settings->logo);
            $logo = 'website/logo/'.$request->file('logo')->hashName();
            $uploaded = $request->file('logo')->storeAs('public', $logo);
            if ($uploaded) {
                $settingsData['logo'] = $logo;
            }
        }
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$settings->image);
            $image = 'website/about/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $image);
            if ($uploaded) {
                $settingsData['image'] = $image;
            }
        }
        // vion
        if ($request->hasFile('image_vision')) {
            $request->validate([
                'image_vision' => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$settings->image_vision);
            $image_vision = 'website/about/'.$request->file('image_vision')->hashName();
            $uploaded = $request->file('image_vision')->storeAs('public', $image_vision);
            if ($uploaded) {
                $settingsData['image_vision'] = $image_vision;
            }
        }
        if ($request->hasFile('image_Objectives')) {
            $request->validate([
                'image_Objectives' => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$settings->image_Objectives);
            $image_Objectives = 'website/about/'.$request->file('image_Objectives')->hashName();
            $uploaded = $request->file('image_Objectives')->storeAs('public', $image_Objectives);
            if ($uploaded) {
                $settingsData['image_Objectives'] = $image_Objectives;
            }
        }

        if ($settings->update($settingsData)) {
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

        return back()->with($notification);
    }
}
