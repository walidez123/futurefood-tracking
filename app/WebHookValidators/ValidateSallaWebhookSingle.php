<?php

namespace App\WebHookValidators;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Exceptions\InvalidWebhookSignature;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class ValidateSallaWebhook implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $signature = $request->header($config->signatureHeaderName);

        if (! $signature) {
            return false;
        }
        $signingSecret = $config->signingSecret;

        if (empty($signingSecret)) {
            throw new InvalidWebhookSignature();
        }

        return $signature === $signingSecret;
    }
}
