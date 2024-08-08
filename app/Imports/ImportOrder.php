<?php

namespace App\Imports;

use App\Models\Address;
use App\Models\AppSetting;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderHistory;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportOrder implements ToModel
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function model(array $row)
    {

        if ($row[1] === 'receved_phone') {
            return null;
        }

        $senderAddress = Address::where('user_id', $this->user->id)->first();
        $appSetting = AppSetting::findOrFail(1);
        $lastOrderID = Order::withTrashed()->orderBy('id', 'DESC')->pluck('id')->first();
        $newOrderID = $lastOrderID + 1;
        $newOrderID = sprintf('%07s', $newOrderID);
        $orderId = $appSetting->order_number_characters.$newOrderID;
        $trackId = $this->user->tracking_number_characters.'-'.uniqid();

        $receved_city = $row[2];
        // dd($receved_city);
        $city = City::where('title', $receved_city)
            ->orWhere('title_ar', $receved_city)->first();
        // dd($city->id);

        $order = new Order([
            'receved_name' => $row[0] ?? null,
            'receved_phone' => $row[1] ?? null,
            'receved_city' => $city->id ?? null,
            'receved_address' => $row[3] ?? null,
            'receved_address_2' => $row[4] ?? null,
            'receved_email' => $row[5] ?? null,
            'amount' => $row[6] ?? null,
            'number_count' => $row[7] ?? 1,
            'reference_number' => $row[8] ?? null,
            'order_weight' => $row[9] ?? null,
            'order_contents' => $row[10] ?? null,
            'receved_notes' => $row[11] ?? null,
            'user_id' => $this->user->id,
            'company_id' => $this->user->company_id,
            'store_address_id' => $senderAddress->id ?? null,
            'sender_city' => $senderAddress->city_id ?? null,
            'sender_phone' => $senderAddress->phone ?? null,
            'sender_address' => $senderAddress->address ?? null,
            'order_id' => $orderId,
            'tracking_id' => $trackId,
            'status_id' => $this->user->default_status_id,
            'pickup_date' => date('y-m-d h:i:s'),

        ]);

        OrderHistory::create(['user_id' => $this->user->id, 'order_id' => $lastOrderID + 1, 'status_id' => $this->user->default_status_id]);

        return $order;
    }
}
