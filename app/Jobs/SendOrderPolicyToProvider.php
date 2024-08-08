<?php

namespace App\Jobs;

use App\ProvidersIntegration\Salla\UpdateShipment;
use App\ProvidersIntegration\Zid\UpdateOrderZid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use App\Models\Company_provider;
use Illuminate\Support\Facades\Log;

class SendOrderPolicyToProvider implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $app_id;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order,$app_id = null)
    {
        $this->order = $order;
        $this->app_id=$app_id;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info( $this->order);
        Log::info( $this->app_id);

        if($this->order->is_returned==1)
        {
            $pdf = PDF::loadView('website.show-as-pdf-return', ['order' => $this->order]);

        }
        else{       
             $pdf = PDF::loadView('website.show-as-pdf', ['order' => $this->order]);
        }

        if (! file_exists(public_path('orders/'.$this->order->order_id.'.pdf'))) {
            $pdf->save(public_path('orders/'.$this->order->order_id.'.pdf'));
            Log::info('pdf save');

        }
        if($this->order->is_returned==1)
        {
            $provider_name=$this->order->Order->providerOrder->provider_name;
            Log::info('return_'.$provider_name);


        }else{
           $provider_name= $this->order->providerOrder->provider_name;
           Log::info($provider_name);

        }


        if ($provider_name == 'salla') {

            if($this->app_id=='' || $this->app_id==null)
            {
                if($this->order->user_id==777)
                {
                    $Company_provider=Company_provider::where('user_id',$this->order->company_id)->where('app_type',1)->where('provider_name','salla')->first();

                }else{
                    $Company_provider=Company_provider::where('user_id',$this->order->company_id)->where('app_type',$this->order->work_type)->where('provider_name','salla')->first();

                }

            }else{

                if($this->order->user_id==777)
                {
                    $Company_provider=Company_provider::where('user_id',$this->order->company_id)->where('app_type',1)->where('provider_name','salla')->first();
                    Log::info('777_'. $Company_provider->app_id);


                }else{
                    $Company_provider=Company_provider::where('app_id',$this->app_id)->where('provider_name','salla')->first();
                    Log::info('salla_company_id_'. $Company_provider);



                }
            }
            

            $updateShipment = new UpdateShipment($Company_provider->app_id);
            $updateShipment->updatePolicy($this->order);
        } elseif ($provider_name == 'zid') {
            $updateOrder = new UpdateOrderZid;
            $updateOrder->updatePolicyZid($this->order);
        }
    }
}