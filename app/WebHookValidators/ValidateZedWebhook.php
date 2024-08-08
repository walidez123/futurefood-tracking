<?php

namespace App\WebHookValidators;

use Illuminate\Http\Request;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class ValidateZedWebhook implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        // TODO: Implement isValid() method.
        return true;
    }
}
