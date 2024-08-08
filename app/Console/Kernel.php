<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\Client_packages_good;
use App\Models\Order;
use App\Helpers\Notifications;
use App\Models\Good;
use App\Models\User;
use App\Models\User_package;

use App\Mail\ClientEmail;
use Illuminate\Support\Facades\Mail;

use App\Models\PaletteSubscription;
use App\Jobs\CalculateWarehouseTransactions;
use Illuminate\Console\Scheduling\Schedule;
use App\Models\Package;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\WebhookClient\Models\WebhookCall;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the job to calculate warehouse transactions monthly
        $schedule->job(new CalculateWarehouseTransactions())->monthlyOn(1, '00:00');

        // Logic to check subscription expiry and schedule subscriptions
        $data = Client_packages_good::with('client.userCost')->get();

        foreach ($data as $good) {
            // Check if the client relationship is defined
            if ($good->client && $good->client->userCost) {
                $sum = $good->number;
                $type = $good->client->userCost->pallet_subscription_type;
                $cost = $good->client->userCost->store_palette;
                $tax = $cost * $good->client->tax / 100;
                $total = $cost + $tax;

                if ($sum > 0) {
                    if ($type == 'daily') {
                        $schedule->call(function () use ($good, $cost,$tax,$total) {
                            $subscription = PaletteSubscription::create([
                                'client_packages_goods_id' => $good->id,
                                'user_id' => $good->client->id,
                                'transaction_type_id' => 18,
                                'description' => "تكلفه تخزين الرف" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax,
                                'cost' => $total,
                                'start_date' => Carbon::now(),
                                'type' => 'daily',
                            ]);
                        })->daily();
                    } elseif ($type == 'monthly') {
                        $schedule->call(function () use ($good, $cost,$tax,$total) {
                            $subscription = PaletteSubscription::create([
                                'client_packages_goods_id' => $good->id,
                                'user_id' => $good->client->id,
                                'transaction_type_id' => 19,
                                'description' => "تكلفه تخزين الرف" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax,
                                'cost' => $total,
                                'start_date' => Carbon::now(),
                                'type' => 'monthly', // Corrected 'daily' to 'monthly'
                            ]);
                        })->monthlyOn(1, '00:00');
                    }
                }
            }
        }


        $schedule->call(function () {
            $orders = Order::whereDate('pickup_date', now()->toDateString())->get();
            foreach ($orders as $order) {
             Notifications::addNotification('طلب شحن اليوم', 'يوجد طلب تاريخ شحن اليوم: '.$order->order_id, 'order', $order->company_id, 'admin', $order->id);
            }
        })->daily();
        
        $schedule->call(function () {
            $packages = User_package::where('publish', 1)->get();
            foreach ($packages as $package) {
                $today = \Carbon\Carbon::today();
                $end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $package->end_date);
        
                if ($today->isSameDay($end_date)) {
                    $package->active = 0;
                    $package->save();
                }
            }
        })->daily();




        $schedule->call(function () {
            // Fetch goods expiring today
            $goods = Good::with('client', 'company')  // Assuming relationships are defined in the Good model
                        ->whereDate('expire_date', now()->toDateString())
                        ->get();
        
            foreach ($goods as $good) {
                // Determine the recipient: default to company, override with client if conditions met
                $recipient = $good->company;  // Assuming company relationship is defined
                if ($good->client && $good->client->email) {
                    $recipient = $good->client;  // Assuming client relationship is defined
                }
                // Check if recipient has an email before sending
                if ($recipient && $recipient->email) {
                    Mail::to($recipient->email)->send(new ClientEmail($recipient, $good));
                }
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
