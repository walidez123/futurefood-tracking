<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Models\WebhookCall;

class AymakanWebHookJob extends ProcessWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WebhookCall $webhookCall)
    {
        parent::__construct($webhookCall);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $webHookPayloadObject = json_decode(json_encode($this->webhookCall->payload));

        Log::info($webHookPayloadObject);


        if (isset($webHookPayloadObject->event)){
                event(new ShipmentUpdateStatusEvent($webHookPayloadObject));
            
        }
    }
}
