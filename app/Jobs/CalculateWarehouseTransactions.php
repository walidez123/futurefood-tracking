<?php

namespace App\Jobs;

use App\Helpers\CompanyTransactions;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateWarehouseTransactions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::whereHas('companyWorks', function ($query) {
            $query->where('work', 4);
        })->get();

        // Process warehouse transactions for each user
        foreach ($users as $user) {
            CompanyTransactions::processWarehouse($user);
        }
    }
}
