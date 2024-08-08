<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\Adaptors\MerchantDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SaveMerchantDataFromProvider implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $merchantDetails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MerchantDetails $merchantDetails)
    {
        $this->merchantDetails = $merchantDetails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::where('email', $this->merchantDetails->getEmail())->first();
        $company_id = 2;
        if ($this->merchantDetails->getProvider() == 'salla') {
            $company_id = 2;
        } elseif ($this->merchantDetails->getProvider() == 'foodics') {
            $company_id = 2;

        }
        if (is_null($user)) {
            User::create([
                'avatar' => $this->merchantDetails->getAvatar(),
                'name' => $this->merchantDetails->getName(),
                'user_type' => 'client',
                'email' => $this->merchantDetails->getEmail(),
                'email_verified_at' => now(),
                'password' => Str::random(10),
                'domain' => $this->merchantDetails->getWebsite(),
                'store_name' => $this->merchantDetails->getStoreName(),
                'logo' => $this->merchantDetails->getAvatar(),
                'phone' => $this->merchantDetails->getPhone(),
                'website' => $this->merchantDetails->getWebsite(),
                'provider' => $this->merchantDetails->getProvider(),
                'merchant_id' => $this->merchantDetails->getMerchantId(),
                'client_name' => $this->merchantDetails->getName(),
                'client_email' => $this->merchantDetails->getEmail(),
                'client_mobile' => $this->merchantDetails->getPhone(),
                'provider_store_owner_name' => $this->merchantDetails->getStoreOwnerName(),
                'provider_store_id' => $this->merchantDetails->getMerchantId(),
                'provider_store_name' => $this->merchantDetails->getStoreName(),
                'provider_access_token' => $this->merchantDetails->getAccessToken(),
                'provider_refresh_token' => $this->merchantDetails->getRefreshToken(),
                'provider_access_expiry' => $this->merchantDetails->getAccessExpire(),
                'default_status_id' => 1,
                'company_id' => $company_id,
                'work' => $this->merchantDetails->getStoreType(),
            ]);
        } else {
            $user->provider_access_token = $this->merchantDetails->getAccessToken();
            $user->save();
        }

    }
}
