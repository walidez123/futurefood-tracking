<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;
use Illuminate\Support\Facades\Log;


class SallaWebHookJob extends ProcessWebhookJob implements ShouldQueue
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

        log::info('salla jobs');

        $webHookPayloadObject = json_decode(json_encode($this->webhookCall->payload));


        


        $className = str_replace(' ', '', ucwords(str_replace('.', ' ', $webHookPayloadObject->event)));
        $eventClass = "\App\Events\SallaEvents\{$className}";
        $eventClass = str_replace('}', '', str_replace('{', '', $eventClass));

            log::info($eventClass);




        if (class_exists($eventClass)) {
            event(new $eventClass($webHookPayloadObject));
        }
    }
}