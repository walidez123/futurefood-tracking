<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use App\Models\Subscription;



use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function showForm()
    {
        return view('website.subscribe');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|max:255',
            'company_name' => 'required|max:255',
            'industry' => 'required|max:255',
            'user_name' => 'required|max:255',
            'phone_number' => 'required|max:255',
            'email' => 'required|email',
            'additional_info' => 'nullable'
        ]);

        Subscription::create($validated);

        return redirect()->back()->with('success', 'Thank you for subscribing!');
    }
}
