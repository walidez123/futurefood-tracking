<?php

namespace App\Helpers;

use App\Models\CompanyTransaction;
use App\Models\Order;
use Carbon\Carbon;

class CompanyTransactions
{
    /*calculate order cost for lastmile, resturant and fullfilment
    Note: Warehouse subiscribtoin is monthly */
    private static function checkExistingTransaction($orderId, $typeId)
    {
        return CompanyTransaction::where('order_id', $orderId)->where('transaction_type_id', $typeId)->first();
    }

    private static function createTransaction($userId, $amount, $orderId, $typeId, $creditorUserId = null, $debtorAmount = null)
    {
        $transaction = new CompanyTransaction();
        $transaction->user_id = $userId;
        $transaction->creditor = $amount;
        if ($orderId) {
            $transaction->order_id = $orderId;
        }

        $transaction->transaction_type_id = $typeId;

        if ($creditorUserId) {
            $transaction->creditor_user_id = $creditorUserId;
        }

        if ($debtorAmount) {
            $transaction->debtor_amount = $debtorAmount;
        }

        $transaction->created_at = Carbon::now();
        $transaction->save();
    }

    public static function addToCompanyTransaction($order)
    {
        switch ($order->user->work) {
            case 1:
                self::processWorkType1($order);
                break;
            case 2:
                self::processWorkType2($order);
                break;
            case 4:
                self::processWorkType4($order);
                break;
        }
    }

    private static function processWorkType1($order) //lastmile_cost, salla_cost
    {
        self::processStoreNewOrder($order, 14);
    }

    private static function processWorkType2($order) //foodics_cost, food_delivery_cost
    {
        self::processResturantNewOrder($order, 14);
    }

    private static function processWorkType4($order) //fulfillment_cost
    {
        self::processFulfillmentNewOrder($order, 14);
    }

    private static function processStoreNewOrder($order, $typeId)
    {
        $transaction = self::checkExistingTransaction($order->id, $typeId);

        if (!$transaction) {
            if($order->providerOrder!=NULL)
            {

            
            if ($order->providerOrder->provider_name == 'salla')
            {   
                $cost = $order->user->company->companyCost->salla_cost;
                $tax = $cost * $order->user->tax / 100;
                $total = $cost + $tax;
            }
            if ($order->providerOrder->provider_name == 'zid')
            {   
               
                $cost = $order->user->company->companyCost->zid_cost;
                $tax = $cost * $order->user->tax / 100;
                $total = $cost + $tax;            
            }
        }
            else{
                $cost = $order->user->company->companyCost->lastmile_cost;
                $tax = $cost * $order->user->tax / 100;
                $total = $cost + $tax;
            }

            self::createTransaction($order->user->company->id, $total, $order->id, $typeId);
        }
    }

    private static function processResturantNewOrder($order, $typeId)
    {
        $transaction = self::checkExistingTransaction($order->id, $typeId);

        if (! $transaction) {
            if ($order->providerOrder) {
                $cost = $order->user->company->companyCost->foodics_cost;
                $tax = $cost * $order->user->tax / 100;
                $total = $cost + $tax;
            } else {
                $cost = $order->user->company->companyCost->food_delivery_cost;
                $tax = $cost * $order->user->tax / 100;
                $total = $cost + $tax;
            }

            self::createTransaction($order->user->company->id, $total, $order->id, $typeId);
        }
    }

    private static function processFulfillmentNewOrder($order, $typeId)
    {
        $transaction = self::checkExistingTransaction($order->id, $typeId);

        if (! $transaction) {
            $cost = $order->user->company->companyCost->fulfillment_cost;
            $tax = $cost * $order->user->tax / 100;
            $total = $cost + $tax;
            self::createTransaction($order->user->company->id, $total, $order->id, $typeId);
        }
    }

    private static function processSallaNewOrder($order)
    {
        $transaction = self::checkExistingTransaction($order->id, 15);

        if (! $transaction) {
            $cost = $order->user->company->companyCost->salla_cost;
            $tax = $cost * $order->user->tax / 100;
            $total = $cost + $tax;
            self::createTransaction($order->user->company->id, $total, $order->id, 15);
        }
    }

    private static function processFoodicsNewOrder($order)
    {
        $transaction = self::checkExistingTransaction($order->id, 16);

        if (! $transaction) {
            $cost = $order->user->company->companyCost->foodics_cost;
            $tax = $cost * $order->user->tax / 100;
            $total = $cost + $tax;
            self::createTransaction($order->user->company->id, $total, $order->id, 16);
        }
    }

    public static function processWarehouse($user)
    {
        $transaction = CompanyTransaction::where('user_id', $user->id)
            ->where('transaction_type_id', 17)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->first();

        if (! $transaction) {
            $cost = $user->companyCost->warehouse_cost;
            $tax = $cost * $user->tax / 100;
            $total = $cost + $tax;
            self::createTransaction($user->id, $total, null, 17);
        }
    }
}
