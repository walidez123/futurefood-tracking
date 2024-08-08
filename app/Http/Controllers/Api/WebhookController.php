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

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $rules = [
            'order_id' => 'required|numeric',
            'status_id' => 'required|numeric',
            'url' => 'required|url',
            'user_secret' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ]);
        }

        $order_id = $request->order_id;
        $status_id = $request->status_id;
        $user_secret = $request->user_secret;
        $webhookUrl = $request->url;

        if ($user_secret == config('app.webhook_secret')) {
            $order = Order::findOrFail($order_id);

            $order->update([
                'status_id' => $status_id,
            ]);

            ClientTransactions::addToClientTransactions($order);
            OrderHistory::addToHistory($order->id, $status_id);

            $webhookPayload = ['order' => $order];

            $webhookCall = $webhookCall = WebhookCall::create()
                ->url($webhookUrl)
                ->payload($webhookPayload)
                ->useSecret(config('app.webhook_secret'));

            Log::info("Webhook Call Details: URL: {$webhookUrl}, Payload: ".json_encode($webhookPayload));

            // Dispatch the webhook call
            $webhookResponse = $webhookCall->dispatch();

            // Log the response
            Log::info('Webhook Response: '.json_encode($webhookResponse));

            return response()->json(['message' => 'Webhook send successfully'], 200);
        } else {
            return response()->json(['message' => 'User secret is wrong'], 403);
        }

    }
}
