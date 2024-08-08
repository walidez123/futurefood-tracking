<?php

namespace App\Listeners\FoodicsListeners;

use App\Events\FoodicsEvents\OrderDeliveryCreated;
use App\Helpers\OrderHistory;
use App\Models\Address;
use App\Models\AppSetting;
use App\Models\Order;
use App\Models\ProviderOrder;
use App\Models\User;
use Illuminate\Support\Facades\Log;

use App\ProvidersIntegration\Foodics\Branches;
use App\ProvidersIntegration\Foodics\Enums\OrderStatus;
use App\Services\OrderAssignmentService;
use Carbon\Carbon;

class OrderDeliveryCreatedListener
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
    public function handle(OrderDeliveryCreated $event): void
    {
        $this->createOrder($event->webHookPayloadObject);
    }

    private function createOrder($webhookPayload)
    {
        $user = User::where('merchant_id', $webhookPayload->business->reference)->first();
        Log::info($user);


        if (is_null($user)) {

            return;

        }

        if ($webhookPayload->order->status != OrderStatus::Active->value) {
            Log::info('no foodics status');


            return;
        }

        if (empty($webhookPayload->order->products)) {
            Log::info('no foodics products');

            return;
        }


        $appSetting = AppSetting::findOrFail(1);
        $providerOrder = ProviderOrder::where('provider_order_id', $webhookPayload->order->id)
            ->first();
        if (is_null($providerOrder)) {
            $savedOrder = $this->saveOrder($webhookPayload, $appSetting, $user);
            $this->storeOrderProducts($webhookPayload->order->products, $webhookPayload->order->combos, $savedOrder);
            $this->saveProviderOrder($savedOrder, $webhookPayload);
            Log::info('foodics order_ '.$savedOrder);

            $assignmentService = new OrderAssignmentService();
            $assignmentService->assignToDelegate($savedOrder->id);
            $assignmentService->assignToService_Provider($savedOrder->id);
         

            OrderHistory::addToHistory($savedOrder->id, $savedOrder->status_id, $savedOrder->status->description);

        } else {
            $savedOrder = $providerOrder->order;
        }

        return $savedOrder;
    }

    private function storeOrderProducts($products, $combos, $order)
    {
        foreach ($products as $product) {
            $order->product()->create([
                'product_name' => $product->product->name,
                'price' => $product->product->price,
                'number' => $product->quantity,
            ]);
        }
        foreach ($combos as $combo) {
            $price = 0;
            foreach ($combo->products as $product) {
                $price += $product->product->price;
            }
            $order->product()->create([
                'product_name' => $combo->combo_size->combo->name,
                'size' => $combo->combo_size->name,
                'number' => $combo->quantity,
                'price' => $price,
            ]);
        }

    }

    private function saveOrder($webhookPayload, $appSettings, $user)
    {
        $total = $webhookPayload->order->total_price;
        $totalPayment = 0;
        foreach ($webhookPayload->order->payments as $payment) {
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

        $branch = $this->getBranchDetails($webhookPayload->order->branch, $user);
        $orderData = [
            'store_address_id' => $branch->id,
            'provider' => 'Foodics',
            // 'longitude'                         => $webhookPayload->order->branch->longitude,
            // 'latitude'                          => $webhookPayload->order->branch->latitude,
            'sender_name' => $branch->description,
            'pickup_date' => Carbon::parse($webhookPayload->order->driver_collected_at)->format('Y-m-d'),
            'receved_name' => $webhookPayload->order->customer->name,
            'receved_phone' => $webhookPayload->order->customer->dial_code.' '.$webhookPayload->order->customer->phone,
            'receved_address' => $webhookPayload->order->customer_address->description,
            'receved_address_2' => $webhookPayload->order->customer_address->delivery_zone?->name,
            'order_contents' => '',
            'order_weight' => '',
            'amount' => $amountToPay,
            'reference_number' => $webhookPayload->order->reference,
            'company_id' => $user->company_id,
            'work_type' => 2,
            'amount_paid' => $amountToPay == 0 ? 1 : 0,
        ];

        $lastOrderID = Order::withoutTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
        $newOrderID = $lastOrderID + 1;
        $lengthOfNewOrderId = strlen((string) $newOrderID);
        if ($lengthOfNewOrderId < 7) {
            for ($i = 1; $i < $lengthOfNewOrderId; $i++) {
                $newOrderID = '0'.$newOrderID;
            }
        }

        $orderId = $appSettings->order_number_characters.$newOrderID;
        $orderData['order_id'] = $orderId;
        $trackId = $user->tracking_number_characters.'-'.uniqid();
        $orderData['tracking_id'] = $trackId;
        $orderData['status_id'] = $user->default_status_id;
        $savedOrder = $user->orders()->create($orderData);

        return $savedOrder;
    }

    private function getBranchDetails($foodicsBranch, User $user)
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

    private function saveProviderOrder($order, $webhookPayload)
    {
        $status = OrderStatus::from($webhookPayload->order->status);
        $order->providerOrder()->create([
            'provider_order_id' => $webhookPayload->order->id,
            'reference_id' => $webhookPayload->order->reference,
            'shipping_id' => $webhookPayload->order->id,
            'status_id' => $webhookPayload->order->status,
            'status_name' => $status->name,
            'provider_name' => 'foodics',
        ]);
    }
}
