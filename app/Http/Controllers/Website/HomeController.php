<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Services;
use App\Models\Slider;
use App\Models\WhatWeDo;
use Illuminate\Http\Request;
use App\Models\AppSetting;
use App\Models\Faq;
use App\Models\WebSetting;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = [];
        $partners = [];
        $whatWeDo = [];
        $services = [];
        if (Schema::hasTable('sliders')) {
            $sliders = Slider::get();
        }
        if (Schema::hasTable('partners')) {
            $partners = Partner::get();
        }
        if (Schema::hasTable('what_we_dos')) {
            $whatWeDo = WhatWeDo::get();
        }
        if (Schema::hasTable('services')) {
            $services = Services::get();
        }

        // $latestPosts = Post::Post()->Published()->latest()->limit(3)->get();
        // $reviews = RateOrder::where('is_publish', 1)->orderBy('created_at', 'DESC')->take(8)->get();
        return view('website.index', compact('sliders', 'whatWeDo', 'services', 'partners'));
    }

    public function contact()
    {
        return view('website.contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'required',
            'subject' => 'required|max:100',
            'message' => 'required|max:200',
        ]);
        Contact::create($request->all());
        [
            'message' => __('website.send_success'),
            'alert-type' => 'success',
        ];

        return back()->with('error', 'website.send_success');
    }

    public function tracking(Request $request)
    {
        return view('website.track');

    }

    public function track(Request $request)
    {
        if ($request->tracking_id) {
            $order = Order::where('tracking_id', $request->tracking_id)->first();
            if ($order) {
                $orderDetails = $order;
                $orderHistory = $order->history()->get();

                return view('website.track', compact('orderHistory', 'orderDetails'));
            } else {
                $track_num = $request->tracking_id;

                return view('website.track', compact('track_num'));
            }
        } else {
            abort(404);
        }
    }

    public function services()
    {
        $services = Services::orderBy('id', 'desc')->get();

        return view('website.services', compact('services'));
    }

    public function termsDelegate(){
        $Appsetting=AppSetting::first();
        return view('website.termsDelegate', compact('Appsetting'));

    }

    public function privacy_policy(){
        $terms=WebSetting::select('terms_en','terms_ar')->first();
        return view('website.privacy_policy', compact('terms'));

    }
    public function faqs(){
        $faqs=Faq::get();
        return view('website.faqs', compact('faqs'));

    }

}
