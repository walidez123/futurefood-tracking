<?php

namespace App\Http\Controllers\super_admin;

use App\Models\TransferClient;
use App\Models\User;
use Illuminate\Http\Request;

class TransferClientsController
{
    public function transferClients()
    {

        $clients = User::where('user_type', 'client')->get();
        $companies = User::where('user_type', 'admin')->where('is_company', 1)->orderBy('id', 'desc')->paginate(25);

        return view('super_admin.transfer_clients.transfer', compact('clients', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'to_company_id' => 'required',
        ]);
        $transfer_user = User::where('id', $request->client_id)->first();

        if ($transfer_user->company_id == $request->to_company_id) {
            return redirect()->back()->with('error', 'The client is in the same company');
        } else {

            $request->merge(['from_company_id' => $transfer_user->company_id]);

            $created = TransferClient::create($request->all());

            $updated = $transfer_user->update(['company_id' => $request->to_company_id]);

            if ($transfer_user->orders) {
                foreach ($transfer_user->orders as $order) {
                    $order->update(['company_id' => $request->to_company_id]);
                }
            }

            if ($updated) {
                return redirect()->back()->with('success', 'transfer client successfully');
            } else {
                return redirect()->back()->with('error', 'Somthing went wrong!');
            }
        }

    }
}
