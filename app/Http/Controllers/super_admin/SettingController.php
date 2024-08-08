<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
    }

    public function edit()
    {
        $settings = AppSetting::where('id', 1)->first();

        return view('super_admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = AppSetting::where('id', 1)->first();
        $settingsData = $request->all();

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
