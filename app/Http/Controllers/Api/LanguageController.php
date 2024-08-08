<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function __construct()
    {

    }

    public function changeLanguage(Request $request)
    {
        // Store the selected language in session
        $lang = $request->lang;
        Session::put('api_language', $lang);
        Session::save();

        return response()->json([
            'success' => 1,
            'message' => __('api_massage.Saved successfully'),
        ], 200);
    }
}
