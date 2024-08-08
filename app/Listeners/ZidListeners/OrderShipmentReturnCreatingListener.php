<?php

namespace App\Listeners\ZidListeners;

use App\Events\ZidEvents\OrderShipmentReturnCreatingEvent;
use App\Helpers\OrderHistory;
use App\Models\Address;
use App\Models\AppSetting;
use App\Models\City;
use App\Models\Order;
use App\Models\ProviderOrder;
use App\Models\User;
use App\Services\OrderAssignmentService;
use Carbon\Carbon;

class OrderShipmentReturnCreatingListener
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
     *
     * @return void
     */
    public function handle(OrderShipmentReturnCreatingEvent $event)
    {
        $this->createOrder($event->webHookPayloadObject);
    }

    private function createOrder($webHookPayloadObject)
    {
        $user = User::where('merchant_id', $webHookPayloadObject->store_id)->first();
        if (is_null($user)) {
            return;
        }
        $pickUpDate = Carbon::parse($webHookPayloadObject->created_at)->format('Y-m-d');
        if (! isset($webHookPayloadObject->shipping->method)) {
            return;
        }
        $ordersData = $this->ordersData($webHookPayloadObject->products);
        $count=count($webHookPayloadObject->products);

        $storeCityId = $this->getStoreCityId($user->id);
        $shipToCityId = $this->shipToCityId($webHookPayloadObject->shipping->address->city->name);
        $appSetting = AppSetting::findOrFail(1);
        $referenceNumber = $webHookPayloadObject->code;
        $providerOrder = ProviderOrder::where('provider_order_id', $webHookPayloadObject->id)->first();
        if (is_null($providerOrder)) {
            $savedOrder = $this->saveOrder(
                $storeCityId,
                $referenceNumber,
                $webHookPayloadObject,
                $pickUpDate,
                $shipToCityId,
                $ordersData['orderContent'],
                $ordersData['orderWeight'],
                $appSetting,
                $user,
                $count

            );
            $this->storeOrderProducts($webHookPayloadObject->products,$savedOrder);

            $this->saveProviderOrder($savedOrder, $webHookPayloadObject);
            $assignmentService = new OrderAssignmentService();
            $assignmentService->assignToDelegate($savedOrder->id);
            $assignmentService->assignToService_Provider($savedOrder->id);
          

            OrderHistory::addToHistory($savedOrder->id, $savedOrder->status ? $savedOrder->status->title : null, $savedOrder->status ? $savedOrder->status->description : null, $user->default_status_id);
        } else {
            $savedOrder = $providerOrder->order;
        }
    }

    private function storeOrderProducts($products,$order)
    {
        foreach ($products as $product){
            $order->product()->create([
                'product_name' => $product->name,
                'price'        => $product->price,
                'number'       => $product->quantity
            ]);
        }
    }

    private function ordersData($orders)
    {
        $orders = (array) $orders;
        if (count($orders) == 1) {
            $order = current($orders);
            $orderContent = $order->name;
            $orderWeight = $order->weight;
        } else {
            $orderContent = '';
            $orderWeight = 0;
            foreach ($orders as $order) {
                $orderContent .= $order->name.', ';
                if ($order->weight) {
                    $orderWeight += $order->weight->value;
                }
            }
        }

        return ['orderContent' => $orderContent, 'orderWeight' => $orderWeight];
    }

    private function getStoreCityId($userID)
    {
        $storeCityId = Address::where(['user_id' => $userID])->first()->city_id;

        return $storeCityId;
    }

    private function shipToCityId($city)
    {
        if ($city !== 'الرياض') {
            $dbCity = City::where('title', $city)->first();
            if (! $dbCity) {
                $newCity = City::insert(['title' => $city]);
                $newCityId = $newCity->id;
            } else {
                $newCityId = $dbCity->id;
            }
        } else {
            $newCityId = 101; //RiyadhCityId;
        }

        return $newCityId;
    }

    private function saveOrder($storeOrderId, $referenceNumber, $shippingData, $pickUpDate, $shipToCityId, $orderContent, $orderWeight, $appSettings, $user,$count)
    {
        $orderData = [
            
            'sender_city'                       => $storeOrderId,
            'sender_name'                       => $shippingData->store_name,
            'sender_phone'                       => $shippingData->store_name,
            'sender_address'                    => $shippingData->inventory_address,
            'pickup_date'                       => $pickUpDate,
            'receved_name'                      => $shippingData->customer->name,
            'receved_phone'                     => $shippingData->customer->mobile,
            'receved_email'                     => $shippingData->customer->email,
            'receved_city'                      => $shipToCityId,
            'receved_address'                   => $shippingData->shipping->address->street . " " . $shippingData->shipping->address->district,
            'receved_address_2'                 => $shippingData->shipping->address->street . " " . $shippingData->shipping->address->district,
            'order_contents'                    => $orderContent,
            'order_weight'                      => $orderWeight,
            'amount'                            => $shippingData->order_total,
            'number_count'                      =>$count,
            'reference_number'                  => $referenceNumber,
            'is_returned'                       => 1,
            'company_id'                        => $user->company_id,
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

    private function saveProviderOrder($order, $webHookPayloadObject)
    {
        $order->providerOrder()->create([
            'provider_order_id' => $webHookPayloadObject->id,
            'reference_id' => $webHookPayloadObject->code,
            'shipping_id' => $webHookPayloadObject->shipping->method->id,
            'status_id' => $webHookPayloadObject->histories ? $webHookPayloadObject->histories[0]->order_status_id : 0,
            'status_name' => $webHookPayloadObject->order_status->name,
            'provider_name' => 'zid',
        ]);
    }
}
