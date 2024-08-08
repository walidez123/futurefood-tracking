<?php

namespace App\Helpers;

use App\Models\City_zone;
use App\Models\CompanyTransaction as CompanyTransactionsModels;
use App\Models\Zone_account;
use Carbon\Carbon;

class CompanyTransactions
{
    public static function addToCompanyTransactions($order)
    {
        switch ($order->work_type) {
            case 1:
                self::processWorkType1($order);
                break;

            case 2:
                self::processWorkType2($order);
                break;
            case 4:
                self::processWorkType4($order);
                break;
            default:
                self::processDefaultWorkType($order);
                break;
        }
    }

    private static function processWorkType1($order)
    {
        if ($order->status_id == $order->user->cost_calc_status_id) {
            self::processCostCalcStatus($order, 1);
        } elseif ($order->status_id == $order->user->cost_calc_status_id_outside) {
            self::processCostCalcStatus($order, 1);
        } elseif ($order->status_id == $order->user->cost_reshipping_calc_status_id) {
            self::processCostReshippingCalcStatus($order, 2);
        } elseif ($order->status_id == $order->user->calc_cash_on_delivery_status_id) {
            self::processCalcCashOnDeliveryStatus($order, 3);
        } elseif ($order->status_id == $order->user->available_overweight_status && $order->sender_city == $order->receved_city) {
            self::processAvailableOverweightStatus($order, 5);
        } elseif ($order->status_id == $order->user->available_overweight_status_outside && $order->sender_city != $order->receved_city) {
            self::processAvailableOverweightStatus($order, 5);
        } elseif ($order->status_id == $order->user->available_collect_order_status) {
            self::processAvailableCollectOrderStatus($order, 6);
        }
    }

    private static function processWorkType2($order)
    {
        $zoneSender = City_zone::where('city_id', $order->sender_city)->first();
        $zoneReceive = City_zone::where('city_id', $order->sender_city)->first();
        $zoneAccounts = Zone_account::where('user_id', $order->user_id)->where('zone_id', $zoneSender->zone_id)->first();

        if ($order->status_id == $order->user->cost_calc_status_id && $zoneSender->zone_id == $zoneReceive->zone_id) {
            self::processCostCalcStatus($order, 1, $zoneAccounts);
        } elseif ($order->status_id == $order->user->cost_calc_status_id_outside && $zoneSender->zone_id == $zoneReceive->zone_id) {
            self::processCostCalcStatus($order, 1, $zoneAccounts);
        } elseif ($order->status_id == $order->user->cost_reshipping_calc_status_id) {
            self::processCostReshippingCalcStatus($order, 2, $zoneAccounts);
        } elseif ($order->status_id == $order->user->calc_cash_on_delivery_status_id) {
            self::processCalcCashOnDeliveryStatus($order, 3, $zoneAccounts);
        } elseif ($order->status_id == $order->user->available_overweight_status && $zoneSender->zone_id == $zoneReceive->zone_id) {
            self::processAvailableOverweightStatus($order, 5, $zoneAccounts);
        } elseif ($order->status_id == $order->user->available_overweight_status_outside && $zoneSender->zone_id == $zoneReceive->zone_id) {
            self::processAvailableOverweightStatus($order, 5, $zoneAccounts);
        } elseif ($order->status_id == $order->user->available_collect_order_status) {
            self::processAvailableCollectOrderStatus($order, 6, $zoneAccounts);
        }
    }

    private static function processWorkType4($order)
    {
        if ($order->status_id == $order->user->userStatus->cost_calc_status_id) {
            self::processCostCalcStatus($order, 1);
        } elseif ($order->status_id == $order->user->userStatus->cost_calc_status_id_outside) {
            self::processCostCalcStatus($order, 1);
        } elseif ($order->status_id == $order->user->userStatus->cost_reshipping_calc_status_id) {
            self::processCostReshippingCalcStatus($order, 2);
        } elseif ($order->status_id == $order->user->userStatus->calc_cash_on_delivery_status_id) {
            self::processCalcCashOnDeliveryStatus($order, 3);
        } elseif ($order->status_id == $order->user->userStatus->available_overweight_status && $order->sender_city == $order->receved_city) {
            self::processAvailableOverweightStatus($order, 5);
        } elseif ($order->status_id == $order->user->userStatus->available_overweight_status_outside && $order->sender_city != $order->receved_city) {
            self::processAvailableOverweightStatus($order, 5);
        } elseif ($order->status_id == $order->user->userStatus->available_collect_order_status) {
            self::processAvailableCollectOrderStatus($order, 6);
        }
    }

    private static function processDefaultWorkType($order)
    {
        if ($order->status_id == $order->user->cost_calc_status_id) {
            self::processCostCalcStatus($order, 1);
        } elseif ($order->status_id == $order->user->calc_cash_on_delivery_status_id) {
            self::processCalcCashOnDeliveryStatus($order, 3);
        } elseif ($order->status_id == $order->user->cost_reshipping_calc_status_id) {
            self::processCostReshippingCalcStatus($order, 2);
        }
    }

    private static function processCostCalcStatus($order, $typeId, $zoneAccounts = null)
    {
        $transaction = self::checkExistingTransaction($order->id, $typeId);

        if (! $transaction) {
            $cost = $zoneAccounts ? ($zoneAccounts->cost_inside_zone ?? 0) : $order->user->cost_inside_city;
            $tax = $cost * $order->user->tax / 100;
            $total = $cost + $tax;

            self::createTransaction($order->user_id, "تكلفة شحن طلب رقم : {$order->order_id} مبلغ : {$cost} + ضريبة : {$tax}", $total, $order->id, $typeId);
        }
    }

    private static function processCostReshippingCalcStatus($order, $typeId, $zoneAccounts = null)
    {
        $transaction = self::checkExistingTransaction($order->id, $typeId);

        if (! $transaction) {
            $cost = $zoneAccounts ? ($zoneAccounts->cost_reshipping_zone ?? 0) : $order->user->cost_reshipping;
            self::createTransaction($order->user_id, "تكلفة اعادة شحن طلب رقم : {$order->order_id}", $cost, $order->id, $typeId);
        }
    }

    private static function processCalcCashOnDeliveryStatus($order, $typeId, $zoneAccounts = null)
    {
        if ($order->amount > 0) {
            $transaction = self::checkExistingTransaction($order->id, $typeId);

            if (! $transaction) {
                $fees = $zoneAccounts ? ($zoneAccounts->fees_cash_on_delivery_zone ?? 0) : $order->user->fees_cash_on_delivery;
                $creditorUserId = $typeId == 3 ? $order->delegate_id : $order->user_id;
                $debtorAmount = $typeId == 4 ? $order->amount : null;

                self::createTransaction($order->user_id, "رسوم تحصيل مبلغ مالي للطلب رقم : {$order->order_id}", $fees, $order->id, $typeId);
                self::createTransaction($order->delegate_id, "تحصيل مبلغ مالي للطلب رقم : {$order->order_id}", $order->amount, $order->id, $typeId, $creditorUserId, $debtorAmount);
            }
        }
    }

    private static function processAvailableOverweightStatus($order, $typeId, $zoneAccounts = null)
    {
        $transaction = self::checkExistingTransaction($order->id, $typeId);

        if (! $transaction) {
            $cost = $zoneAccounts ? ($zoneAccounts->overweight_zone ?? 0) : $order->user->overweight;
            self::createTransaction($order->user_id, "تكلفة زيادة الوزن للطلب رقم : {$order->order_id}", $cost, $order->id, $typeId);
        }
    }

    private static function processAvailableCollectOrderStatus($order, $typeId, $zoneAccounts = null)
    {
        $transaction = self::checkExistingTransaction($order->id, $typeId);

        if (! $transaction) {
            $cost = $zoneAccounts ? ($zoneAccounts->collect_order_zone ?? 0) : $order->user->collect_order;
            self::createTransaction($order->user_id, "تكلفة جمع الطلب للطلب رقم : {$order->order_id}", $cost, $order->id, $typeId);
        }
    }

    private static function checkExistingTransaction($orderId, $typeId)
    {
        return CompanyTransactionsModels::where('order_id', $orderId)->where('type_id', $typeId)->first();
    }

    private static function createTransaction($userId, $description, $amount, $orderId, $typeId, $creditorUserId = null, $debtorAmount = null)
    {
        $transaction = new CompanyTransactionsModels();
        $transaction->user_id = $userId;
        $transaction->description = $description;
        $transaction->creditor = $amount;
        $transaction->order_id = $orderId;
        $transaction->type_id = $typeId;

        if ($creditorUserId) {
            $transaction->creditor_user_id = $creditorUserId;
        }

        if ($debtorAmount) {
            $transaction->debtor_amount = $debtorAmount;
        }

        $transaction->created_at = Carbon::now();
        $transaction->save();
    }
}
