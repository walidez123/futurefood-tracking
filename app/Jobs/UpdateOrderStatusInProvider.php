<?php

namespace App\Jobs;

use App\Models\Order;
use App\ProvidersIntegration\Foodics\Orders;
use App\ProvidersIntegration\Salla\UpdateOrderStatus;
use App\ProvidersIntegration\Zid\UpdateStatusOrderZid;
use App\Services\Adaptors\Foodics\Foodics;
use App\Services\Adaptors\Zid\Zid;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Company_provider;
use Illuminate\Support\Facades\Log;


class UpdateOrderStatusInProvider implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $providerOrder = $this->order->providerOrder;
        if($providerOrder?->provider_name == 'foodics')
        {

            $orderId = $providerOrder->provider_order_id;
            $token = $this->order->user->provider_access_token;
            $providerStatusId = Foodics::reverseMapDeliveryStatus((int)$this->order->status_id, $this->order->user->company);

            if ($providerStatusId != null) {
                $orders = new Orders();
                $orders->updateOrder($orderId, $token, $providerStatusId);
            }
        }
        elseif ($providerOrder?->provider_name == 'salla')
        {
            if($this->order->user_id==777)
            {
                $Company_provider=Company_provider::where('user_id',$this->order->company_id)->where('app_type',1)->where('provider_name','salla')->first();
                Log::info('status_777_'.$Company_provider);


            }else{
                Log::info('status_company-id_'.$this->order->id);

                $Company_provider=Company_provider::where('user_id',$this->order->company_id)->where('app_type',$this->order->work_type)->where('provider_name','salla')->first();
                if($Company_provider==null){
                    $Company_provider=Company_provider::where('user_id',$this->order->company_id)->where('provider_name','salla')->first();

                }
                Log::info('status_'.$Company_provider);

            }


            $updateOrderStatus = new UpdateOrderStatus($Company_provider->app_id);
            $updateOrderStatus->updateStatus($this->order);
      
        }elseif($providerOrder?->provider_name == 'zid')
        {
                $updateOrderStatus = new UpdateStatusOrderZid();
                $updateOrderStatus->updateOrderStatusZid($this->order);
         
        }
    }
}