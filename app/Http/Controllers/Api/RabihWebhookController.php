<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ClientTransactions;
use App\Helpers\OrderHistory;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\WebhookServer\WebhookCall;

class RabihWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Rabih webhook:', $request->all());
        $data = $request->all();


        $request->validate([
            'order_id' => 'required|integer',
            'status_id' => 'required|numeric',
        ]);

        $order = Order::find($data['order_id']);
        if ($order) {
            $order->status_id = $data['status_id'];
            $order->save();
        }
        ClientTransactions::addToClientTransactions($order);

        OrderHistory::addToHistory($order->id, $order->status_id);


        // Return a response to acknowledge receipt of the webhook
        return response()->json(['message' => 'Webhook received and processed successfully']);
    }

}
