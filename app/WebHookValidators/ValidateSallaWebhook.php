<?php

namespace App\WebHookValidators;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Exceptions\InvalidWebhookSignature;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;
use Illuminate\Support\Facades\Log;


class ValidateSallaWebhook implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $signature = $request->header($config->signatureHeaderName);

        if (! $signature) {

            return false;
        }
        $signingSecret = $config->signingSecret;

        $secrets = explode(',',$config->signingSecret);
        if (empty($signingSecret)) {
            throw new InvalidWebhookSignature();
        }

        foreach ($secrets as $secret) {
            if ($secret === $signature) {

                return true;
            }
        }
        

    }
}