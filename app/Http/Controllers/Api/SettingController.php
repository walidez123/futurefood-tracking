<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Http\Resources\TermResource;
use App\Models\AppSetting;

class SettingController extends Controller
{
    public function Setting()
    {

        $Setting = SettingResource::collection(AppSetting::get());
        if (count($Setting) == 0) {
            return response()->json(['message' => 'No setting found']);
        } else {
            return response()->json($Setting);
        }

    }

   
}
