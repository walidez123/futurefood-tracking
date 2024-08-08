<?php

namespace App\Listeners\FoodicsListeners;

use App\Events\FoodicsEvents\OrderDeliveryCreated;
use App\Events\FoodicsEvents\OrderDeliveryUpdated;
use App\Models\Address;
use App\Models\ProviderOrder;
use App\ProvidersIntegration\Foodics\Branches;
use App\ProvidersIntegration\Foodics\Enums\OrderDeliveryStatus;
use App\ProvidersIntegration\Foodics\Enums\OrderStatus;
use App\ProvidersIntegration\Foodics\Orders;
use App\Services\Adaptors\Foodics\Foodics;
use Illuminate\Support\Carbon;

class OrderDeliveryUpdatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderDeliveryUpdated $event): void
    {
        //for amount
        $total = $event->webHookPayloadObject->order->total_price;
        $totalPayment = 0;
        foreach ($event->webHookPayloadObject->order->payments as $payment) {
            $totalPayment += $payment->amount;
        }

        if ($totalPayment > 0) {
            if ($total > $totalPayment) {
                $amountToPay = $total - $totalPayment;
            } else {
                $amountToPay = 0;
            }
        } else {
            $amountToPay = $total;
        }

        $providerOrder = ProviderOrder::where('provider_order_id',
            $event->webHookPayloadObject->order->id)->first();

        if ($providerOrder != null) {
            $providerStatus = OrderStatus::from($event->webHookPayloadObject->order->status);
            $providerOrder->update([
                'status_id' => $providerStatus->value,
                'status_name' => $providerStatus->name,
            ]);

            $order = $providerOrder->order;
            if (is_null($order)) {
                $providerOrder->delete();

                return;
            }
            $branch = $this->getBranchDetails($event->webHookPayloadObject->order->branch, $order->user);
            if ($order != null) {
                if ($order->status_id == $order->user->company->companyFoodicsStatus->closed_id) {
                    $order->update([
                        'store_address_id' => $branch->id,
                        'amount' => $amountToPay,
                        'sender_name' => $branch->description,
                        'pickup_date' => Carbon::parse($event->webHookPayloadObject->order->driver_collected_at)->format('Y-m-d'),
                        'receved_name' => $event->webHookPayloadObject->order->customer->name,
                        'receved_phone' => $event->webHookPayloadObject->order->customer->dial_code.' '.$event->webHookPayloadObject->order->customer->phone,
                        'receved_address' => $event->webHookPayloadObject->order->customer_address->description,
                        'receved_address_2' => $event->webHookPayloadObject->order->customer_address?->delivery_zone?->name,
                    ]);

                } else {
                    $order->update([
                        'store_address_id' => $branch->id,
                        'sender_name' => $branch->description,
                        'pickup_date' => Carbon::parse($event->webHookPayloadObject->order->driver_collected_at)->format('Y-m-d'),
                        'receved_name' => $event->webHookPayloadObject->order->customer->name,
                        'receved_phone' => $event->webHookPayloadObject->order->customer->dial_code.' '.$event->webHookPayloadObject->order->customer->phone,
                        'receved_address' => $event->webHookPayloadObject->order->customer_address->description,
                        'receved_address_2' => $event->webHookPayloadObject->order->customer_address?->delivery_zone?->name,
                    ]);

                }
                $mappingStatus = Foodics::mappingDeliveryStatus((int) $event->webHookPayloadObject->order->delivery_status, $user->company);
                if ($mappingStatus != null) {
                    $order->update([
                        'status_id' => $mappingStatus,
                    ]);
                }
                if ($event->webHookPayloadObject->order->status == OrderStatus::Void->value) {
                    $order->update([
                        'status_id' => 34,
                    ]);
                }

                //               if($event->webHookPayloadObject->order->delivery_status == OrderDeliveryStatus::READY){
                //                   $orders = new Orders();
                //
                //                   $orders->updateOrder($providerOrder->provider_order_id,
                //                       $order->user->provider_access_token,OrderDeliveryStatus::ASSIGNED);
                //               }
            }
        } else {
            event(new OrderDeliveryCreated($event->webHookPayloadObject));
        }
    }

    private function getBranchDetails($foodicsBranch, $user)
    {
        $address = Address::where('branch', $foodicsBranch->id)->where('user_id', $user->id)->first();

        if (is_null($address)) {
            $branches = new Branches();
            $branchDetails = $branches->getBranchDetails($foodicsBranch->id, $user->provider_access_token);

            if ($branchDetails->ok()) {
                $branch = $branchDetails->json()['data'];
                if (array_key_exists('settings', $branch)) {
                    if (array_key_exists('sa_zatca_branch_address', $branch)) {
                        $branchAddress = $branch['settings']['sa_zatca_branch_address'];
                        $description = $branchAddress['building_number'].' '.$branchAddress['street_name'].
                            ' '.$branchAddress['district'].' '.$branchAddress['city'].' '.$branchAddress['postal_code'];
                    }
                }
                $address = $user->addresses()->create([
                    'longitude' => $branch['longitude'],
                    'latitude' => $branch['latitude'],
                    'phone' => $branch['phone'],
                    'address' => $branch['address'] ?? '',
                    'description' => isset($description) ? $description : "BranchName: {$branch['name']}, 'reference: {$branch['reference']}",
                    'branch' => $branch['id'],
                ]);
            }
        }

        return $address;
    }
}
