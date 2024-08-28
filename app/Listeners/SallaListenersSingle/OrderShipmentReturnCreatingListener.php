<?php

namespace App\Listeners\SallaListeners;

use App\Events\SallaEvents\OrderShipmentReturnCreating;
use App\Helpers\OrderHistory;
use App\Models\Address;
use App\Models\AppSetting;
use App\Models\City;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class OrderShipmentReturnCreatingListener
{
    /**
     * Create the event listener.
     *
     * @return void
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
    public function handle(OrderShipmentReturnCreating $event)
    {
        $this->createOrder($event->webHookPayloadObject);
    }

    private function createOrder($webHookPayloadObject)
    {
        $user = User::where('merchant_id', $webHookPayloadObject->merchant)->first();
        if (is_null($user)) {
            return;
        }
        $shippingData = $webHookPayloadObject->data->shipping;
        $priceBreakDowns = $webHookPayloadObject->data->amounts;
        $pickUpDate = Carbon::parse($webHookPayloadObject->created_at)->format('Y-m-d');
        if (! isset($webHookPayloadObject->data->items)) {
            return;
        }
        $ordersData = $this->ordersData($webHookPayloadObject->data->items);
        $storeCityId = $this->getStoreCityId($shippingData->pickup_address->city);
        $this->saveStoreAddress($user->id, $storeCityId, $shippingData);
        $shipToCityId = $this->shipToCityId($shippingData->address->city);
        $appSetting = AppSetting::findOrFail(1);

        $savedOrder = $this->saveOrder($storeCityId, $shippingData, $pickUpDate, $shipToCityId, $ordersData['orderContent'],
            $ordersData['orderWeight'], $appSetting, $user, $priceBreakDowns);
        $this->saveProviderOrder($savedOrder, $webHookPayloadObject);

        OrderHistory::addToHistory($savedOrder->id, $savedOrder->status->title, $savedOrder->status->description, $user->default_status_id);
    }

    private function ordersData($orders)
    {
        if (count($orders) == 1) {
            $order = current($orders);
            $orderContent = $order->name;
            $orderWeight = $order->weight;
        } else {
            $orderContent = '';
            $orderWeight = 0;
            foreach ($orders as $order) {
                $orderContent .= $order->name.', ';
                $orderWeight += $order->weight;
            }
        }

        return ['orderContent' => $orderContent, 'orderWeight' => $orderWeight];
    }

    private function getStoreCityId($city)
    {
        if ($city !== 'الرياض') {
            $dbCity = City::where('title', $city)->first();
            if (! $dbCity) {
                $newStoreCity = City::create(['title' => $city]);
                $storeCityId = $newStoreCity->id;
            } else {
                $storeCityId = $dbCity->id;
            }
        } else {
            $storeCityId = 101; //RiyadhCityId
        }

        return $storeCityId;
    }

    private function saveStoreAddress($userID, $storeCityId, $shippingData)
    {
        $storeAddress = Address::where(['user_id' => $userID, 'city_id' => $storeCityId])->first();
        if (! $storeAddress) {
            Address::create(['user_id' => $userID, 'city_id' => $storeCityId, 'address' => $shippingData->pickup_address->shipping_address, 'description' => $shippingData->pickup_address->street_number.' '.
                $shippingData->pickup_address->street_number]);
        }
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

    private function saveOrder($storeOrderId, $shippingData, $pickUpDate, $shipToCityId,
        $orderContent, $orderWeight, $appSettings, $user, $amounts)
    {
        if ($amounts->cash_on_delivery->amount == 0) {
            $totalAmount = 0;
        } else {
            $totalAmount = $amounts->total->amount;
        }

        $orderData = [
            'sender_city' => $storeOrderId,
            'sender_phone' => $shippingData->shipper->phone,
            'sender_name' => $shippingData->shipper->name,
            'sender_email' => $shippingData->shipper->email,
            'sender_address' => $shippingData->pickup_address->shipping_address,
            'sender_address_2' => $shippingData->pickup_address->street_number.' '.
                                                   $shippingData->pickup_address->street_number,
            'pickup_date'                       => $pickUpDate,
            'receved_name'                      => $shippingData->receiver->name,
            'receved_phone'                     => $shippingData->receiver->phone,
            'receved_city'                      => $shipToCityId,
            'receved_address'                   => $shippingData->address->shipping_address,
            'receved_address_2'                 => $shippingData->address->street_number. ' '. $shippingData->address->block,
            'order_contents'                    => $orderContent,
            'order_weight'                      => $orderWeight,
            'amount'                            => $totalAmount,
            'is_returned'                       => 1,
            'work_type'                         => 2,
            'company_id'                        => $user->company_id,
        ];

        $lastOrderID = Order::withoutTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
        $newOrderID = $lastOrderID + 1;
        $lengthOfNewOrderId = strlen((string) $newOrderID);
        if ($lengthOfNewOrderId < 7) {
            for ($i = 0; $i < $lengthOfNewOrderId; $i++) {
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
            'provider_order_id' => $webHookPayloadObject->data->id,
            'reference_id' => $webHookPayloadObject->data->reference_id,
            'shipping_id' => $webHookPayloadObject->data->shipping->id,
            'status_id' => $webHookPayloadObject->data->status->id,
            'status_name' => $webHookPayloadObject->data->status->name,
            'provider_name' => 'salla',
        ]);
    }
}
