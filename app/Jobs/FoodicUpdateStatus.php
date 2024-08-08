<?php

namespace App\Jobs;

use App\Models\Order;
use App\ProvidersIntegration\Foodics\Orders;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FoodicUpdateStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $orderId;

    protected $token;

    protected $providerStatusId;

    public function __construct($orderId, $token, $providerStatusId)
    {
        $this->orderId = $orderId;
        $this->token = $token;
        $this->providerStatusId = $providerStatusId;
    }

    public function handle()
    {
        try {
            if ($this->providerStatusId !== null) {
                $foodicsOrders = new Orders();
                $order = Order::find($this->orderId);
                //  if($this->providerStatusId==34 && $order->status_id !=16)
                // {

                // }

                $foodicsOrders->updateOrder($this->orderId, $this->token, $this->providerStatusId);

                // $updated = $order->updateOrderStatus($this->providerStatusId );
                // if($updated){
                //     Log::info('FoodicUpdateStatus');
                // }

            }
            Log::info('FoodicUpdateStatus job started.');
            Log::info('FoodicUpdateStatus job completed successfully.');
        } catch (\Exception $e) {
            Log::error('FoodicUpdateStatus job failed: '.$e->getMessage());
        }
    }
}
