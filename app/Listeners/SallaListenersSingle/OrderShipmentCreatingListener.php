<?php

namespace App\Listeners\SallaListeners;

use App\Events\SallaEvents\OrderShipmentCreating;
use App\Helpers\OrderHistory;
use App\Jobs\SendOrderPolicyToProvider;
use App\Models\Address;
use App\Models\AppSetting;
use App\Models\City;
use App\Models\Order;
use App\Models\ProviderOrder;
use App\Models\User;
use App\Services\OrderAssignmentService;
use Carbon\Carbon;

class OrderShipmentCreatingListener
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
    public function handle(OrderShipmentCreating $event)
    {
        $this->createOrder($event->webHookPayloadObject);
    }

    private function createOrder($webHookPayloadObject)
    {
        $user = User::where('merchant_id', $webHookPayloadObject->merchant)->first();
        if (is_null($user)) {
            return;
        }
        $shippingData = $webHookPayloadObject->data;
        $pickUpDate = Carbon::parse($webHookPayloadObject->created_at)->format('Y-m-d');
        if (! isset($webHookPayloadObject->data->packages)) {
            return;
        }
        $ordersData = $this->ordersData($webHookPayloadObject->data->packages);
        $storeCityId = $this->getStoreCityId($shippingData->ship_from->city);
        $this->saveStoreAddress($user->id, $storeCityId, $shippingData);
        $shipToCityId = $this->shipToCityId($shippingData->ship_to->city);
        $appSetting = AppSetting::findOrFail(1);
        $referenceNumber = $webHookPayloadObject->data->order_reference_id;
        $count=count($webHookPayloadObject->data->packages); //assign the number of product

        $providerOrder = ProviderOrder::where('provider_order_id', $webHookPayloadObject->data->order_id)->first();
        if (is_null($providerOrder)) {
            $savedOrder = $this->saveOrder($storeCityId, $referenceNumber, $shippingData, $pickUpDate, $shipToCityId, $ordersData['orderContent'],
                $ordersData['orderWeight'], $appSetting, $user,$count);
            $this->saveProviderOrder($savedOrder, $webHookPayloadObject);
            $this->storeOrderProducts($webHookPayloadObject->data->packages,$savedOrder);

            $assignmentService = new OrderAssignmentService();
            $assignmentService->assignToDelegate($savedOrder->id);
            $assignmentService->assignToService_Provider($savedOrder->id);
            OrderHistory::addToHistory($savedOrder->id, $savedOrder->status->title, $savedOrder->status->description,$user->default_status_id);
        }else{
            $savedOrder = $providerOrder->order;
        }

        dispatch(new SendOrderPolicyToProvider($savedOrder));
    }
    // save products of order 
    private function storeOrderProducts($packages,$order)
    {
        foreach ($packages as $package){
            $order->product()->create([
                'product_name' => $package['name'],
                'price'        => $package['price']['amount'],
                'number'       => $package['quantity']
            ]);
        }
    }

    private function ordersData($orders)
    {
        if (count($orders) == 1) {
            $order = current($orders);
            $orderContent = $order->name;
            $orderWeight = $order->weight->value;
        } else {
            $orderContent = '';
            $orderWeight = 0;
            foreach ($orders as $order) {
                $orderContent .= $order->name.', ';
                $orderWeight += $order->weight->value;
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
            Address::create(['user_id' => $userID, 'city_id' => $storeCityId, 'address' => $shippingData->ship_from->address_line, 'description' => $shippingData->ship_from->street_number.' '.
                $shippingData->ship_from->address_line.' '.$shippingData->ship_from->postal_code]);
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

    private function saveOrder($storeOrderId, $referenceNumber, $shippingData, $pickUpDate, $shipToCityId,
        $orderContent, $orderWeight, $appSettings, $user,$count)
    {
        $amount_paid=1;
        $amount=0;
        if($shippingData->payment_method=="cod")
        {
            $amount_paid=0;
            $amount=$shippingData->total->amount;

        }

        $orderData = [
            'sender_city' => $storeOrderId,
            'sender_phone' => $shippingData->ship_from->phone,
            'sender_name' => $shippingData->ship_from->name,
            'sender_email' => $shippingData->ship_from->email,
            'sender_address' => $shippingData->ship_from->address_line,
            'sender_address_2' => $shippingData->ship_from->street_number.' '.
                                                   $shippingData->ship_from->street_number,
            'pickup_date'                       => $pickUpDate,
            'receved_name'                      => $shippingData->ship_to->name,
            'receved_phone'                     => $shippingData->ship_to->phone,
            'receved_city'                      => $shipToCityId,
            'receved_address'                   => $shippingData->ship_to->address_line,
            'receved_address_2'                 => $shippingData->ship_to->street_number. ' '. $shippingData->ship_to->block,
            'order_contents'                    => $orderContent,
            'order_weight'                      => $orderWeight,
            'amount'                            => $amount,
            'number_count'                      =>$count,
            'reference_number'                  => $referenceNumber,
            'company_id'                        => $user->company_id,
            'work_type'                        => $user->work,
            "amount_paid"                      =>$amount_paid,
            "payment_method"                   =>$shippingData->payment_method,
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
            'provider_order_id' => $webHookPayloadObject->data->order_id,
            'reference_id' => $webHookPayloadObject->data->order_reference_id,
            'shipping_id' => $webHookPayloadObject->data->id,
            'status_id' => 0,
            'status_name' => $webHookPayloadObject->data->status,
            'provider_name' => 'salla',
        ]);
    }
}
