<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Illuminate\Support\Facades\Log;
use App\Events\FoodicsEvents\OrderDeliveryCreated;


use Spatie\WebhookClient\Models\WebhookCall;

class FoodicsWebHookJob extends ProcessWebhookJob implements ShouldQueue
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

        $tagObject = Arr::where($webHookPayloadObject->order->tags, function ($value) {
            return $value->name == config('foodics.tag_name');
        });

        if (empty($tagObject)) {
            return;
        }
        $className = str_replace(' ', '', ucwords(str_replace('.', ' ', $webHookPayloadObject->event)));
        $eventClass = "\App\Events\FoodicsEvents\{$className}";
        $eventClass = str_replace('}', '', str_replace('{', '', $eventClass));
        Log::info($eventClass);
        if (class_exists($eventClass)) {
            event(new $eventClass($webHookPayloadObject));
        }

    }
}
