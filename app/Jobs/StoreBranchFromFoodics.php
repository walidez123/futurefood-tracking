<?php

namespace App\Jobs;

use App\Models\User;
use App\ProvidersIntegration\Foodics\Branches;
use App\Services\Adaptors\MerchantDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreBranchFromFoodics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $tokenResponse;

    private MerchantDetails $merchantDetails;

    /**
     * Create a new job instance.
     */
    public function __construct($tokenResponse, MerchantDetails $merchantDetails)
    {
        $this->tokenResponse = $tokenResponse;
        $this->merchantDetails = $merchantDetails;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->getAndStoreBranches();
    }

    protected function getAndStoreBranches($page = 1)
    {
        $branches = new Branches();
        $allBranches = $branches->getBranches($this->tokenResponse, $this->merchantDetails, $page);

        if ($allBranches->ok()) {
            $user = User::where('merchant_id', $this->merchantDetails->merchant_id)->first();
            if (is_null($user)) {
                return;
            }

            $this->storeBranch($allBranches->json()['data'], $user);

            $nextUrl = $allBranches->json()['links']['next'];
            if ($nextUrl != null) {
                parse_str(parse_url($nextUrl, PHP_URL_QUERY), $parameters);
                $nextPageNumber = $parameters['page'];
                $this->getAndStoreBranches($nextPageNumber);
            }
        }
    }

    private function storeBranch($branches, $user)
    {
        foreach ($branches as $branch) {
            if (is_null($branch['deleted_at']) && $branch['receives_online_orders']) {
                $user->addresses()->create([
                    'longitude' => $branch['longitude'],
                    'latitude' => $branch['latitude'],
                    'phone' => $branch['phone'],
                    'address' => $branch['address'] ?? '',
                    'description' => "BranchName: {$branch['name']}, 'reference: {$branch['reference']}",
                    'branch' => $branch['id'],
                ]);
            }

        }
    }
}
