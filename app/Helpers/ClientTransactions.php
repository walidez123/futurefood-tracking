<?php

namespace App\Helpers;

use App\Models\City_zone;
use App\Models\ClientTransactions as ClientTransactionsModels;
use App\Models\Order;
use App\Models\Zone_account;
use Carbon\Carbon;

class ClientTransactions
{
    private static function checkExistingTransaction($orderId, $typeId)
    {
        return ClientTransactionsModels::where('order_id', $orderId)->where('transaction_type_id', $typeId)->first();
    }

    private static function createTransaction($userId, $description, $amount, $orderId, $typeId, $creditorUserId = null, $debtorAmount = null)
    {
        $transaction = new ClientTransactionsModels();
        $transaction->user_id = $userId;
        $transaction->description = $description;
        $transaction->creditor = $amount;
        $transaction->order_id = $orderId;
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

    public static function addToClientTransactions($order)
    {

        if ($order->work_type == 1) {
            if ($order->user->cost_type == 1) {
                if ($order->status_id == $order->user->cost_calc_status_id) {
                    // \Log::info('Sender City: ' . $order->sender_city);
                    // \Log::info('Received City: ' . $order->receved_city);

                    $transaction = self::checkExistingTransaction($order->id, 1);
                    if (!$transaction) {
                        if ($order->sender_city == $order->receved_city) {
                            $cost = $order->user->cost_inside_city;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                            // \Log::info('Cost Inside City: ' . $cost);
                        } else {
                            $cost = $order->user->cost_outside_city;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                            // \Log::info('Cost outside City: ' . $cost);
                        }

                        // add order cost to the company
                        CompanyTransactions::addToCompanyTransaction($order);
                        self::createTransaction($order->user_id, "تكلفة شحن طلب رقم : {$order->order_id}" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax, $total, $order->id, 1);

                    }
                }

                if ($order->status_id == $order->user->cost_calc_status_id_outside && $order->sender_city != $order->receved_city) {
                    $transaction = self::checkExistingTransaction($order->id, 1);
                    if (!$transaction) {
                        if ($order->sender_city == $order->receved_city) {
                            $cost = $order->user->cost_inside_city;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                        } else {
                            $cost = $order->user->cost_outside_city;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;

                        }
                        CompanyTransactions::addToCompanyTransaction($order);

                        self::createTransaction($order->user_id, "تكلفة شحن طلب رقم : {$order->order_id}" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax, $total, $order->id, 1);
                    }
                }
                if ($order->status_id == $order->user->cost_reshipping_calc_status_id) {
                    $transaction = self::checkExistingTransaction($order->id, 2);
                    if (!$transaction) {

                        if ($order->sender_city == $order->receved_city) {
                            $cost = $order->user->cost_reshipping;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;

                        } else {
                            $cost = $order->user->cost_reshipping_out_city;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                        }
                        self::createTransaction($order->user_id, "تكلفة اعادة شحن طلب رقم : {$order->order_id}" . ' مبلغ : ' . $total, $total, $order->id, 2);
                    }
                }
                if ($order->status_id == $order->user->calc_cash_on_delivery_status_id) {
                    if ($order->amount > 0) {
                        $transaction = self::checkExistingTransaction($order->id, 3);
                        if (!$transaction) {
                            if ($order->sender_city == $order->receved_city) {
                                $fees = $order->user->fees_cash_on_delivery;
                            } else {
                                $fees = $order->user->fees_cash_on_delivery_out_city;
                            }
                            ClientTransactionsModels::create([
                                'user_id' => $order->user_id,
                                'description' => 'رسوم تحصيل مبلغ مالي للطلب رقم : ' . $order->order_id,
                                'creditor' => $fees,
                                'order_id' => $order->id,
                                'transaction_type_id' => 3,
                            ]);
                            if ($order->delegate_id) {
                                ClientTransactionsModels::create([
                                    'user_id' => $order->delegate_id,
                                    'description' => ' تحصيل مبلغ مالي للطلب رقم : ' . $order->order_id,
                                    'creditor' => $order->amount,
                                    'order_id' => $order->id,
                                    'transaction_type_id' => 4,
                                ]);
                            }

                            ClientTransactionsModels::create([
                                'user_id' => $order->user_id,
                                'description' => ' تحصيل مبلغ مالي للطلب رقم : ' . $order->order_id,
                                'debtor' => $order->amount,
                                'order_id' => $order->id,
                                'transaction_type_id' => 4,
                            ]);
                        }
                    }
                }
                if ($order->status_id == $order->user->available_overweight_status && $order->sender_city == $order->receved_city) {
                    $transaction = self::checkExistingTransaction($order->id, 5);

                    if (!$transaction) {
                        $standard_weight = $order->user->standard_weight;

                        //over_weight_per_kilo_outside
                        if ($order->sender_city == $order->receved_city) {
                            $standard_weight = $order->user->standard_weight;
                            $over_weight_per_kilo = $order->user->over_weight_per_kilo;
                        } else {
                            $standard_weight = $order->user->standard_weight_outside;
                            $over_weight_per_kilo = $order->user->over_weight_per_kilo_outside;
                        }

                        if ($over_weight_per_kilo == null) {
                            $over_weight_per_kilo = 0;
                        }

                        if ($standard_weight == null) {
                            $standard_weight = 0;
                        }
                        if (($order->order_weight - $standard_weight) > 0) {
                            $cost = ($order->order_weight - $standard_weight) * $over_weight_per_kilo;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                            self::createTransaction($order->user_id, "تكلفة الوزن الزائد للطلب  رقم : {$order->order_id}" . ' مبلغ : ' . $total, $total, $order->id, 5);
                        }

                    }
                }
                if ($order->status_id == $order->user->available_overweight_status_outside && $order->sender_city != $order->receved_city) {
                    $transaction = self::checkExistingTransaction($order->id, 5);

                    if (!$transaction) {
                        $standard_weight = $order->user->standard_weight;

                        //over_weight_per_kilo_outside
                        if ($order->sender_city == $order->receved_city) {
                            $standard_weight = $order->user->standard_weight;
                            $over_weight_per_kilo = $order->user->over_weight_per_kilo;
                        } else {
                            $standard_weight = $order->user->standard_weight_outside;
                            $over_weight_per_kilo = $order->user->over_weight_per_kilo_outside;
                        }

                        if ($over_weight_per_kilo == null) {
                            $over_weight_per_kilo = 0;
                        }

                        if ($standard_weight == null) {
                            $standard_weight = 0;
                        }
                        if (($order->order_weight - $standard_weight) > 0) {
                            $cost = ($order->order_weight - $standard_weight) * $over_weight_per_kilo;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                            self::createTransaction($order->user_id, "تكلفة الوزن الزائد للطلب  رقم : {$order->order_id}" . ' مبلغ : ' . $total, $total, $order->id, 5);
                        }

                    }
                }

                if ($order->status_id == $order->user->available_collect_order_status) {
                    $dateNowSubHour = Carbon::now()->subHours(1);
                    $order_ids = ClientTransactionsModels::where('user_id', $order->user_id)->where('transaction_type_id', 6)
                        ->whereDate('created_at', '>=', $dateNowSubHour)->pluck('order_id')->toArray();

                    if (count($order_ids) > 0) {

                        $order_counts = Order::whereIn('id', $order_ids)->where('user_id', $order->user_id)->where('delegate_id', $order->delegate_id)->count();

                        if ($order_counts < 1) {
                            $cost = $order->user->pickup_fees;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                            ClientTransactionsModels::create([
                                'user_id' => $order->user_id,
                                'description' => 'تكلفه  استلام الطلبات من متجرك بمبلغ قيمته : ' . $total,
                                'creditor' => $total,
                                'order_id' => $order->id,
                                'transaction_type_id' => 6,
                            ]);
                        }
                    } else {
                        $cost = $order->user->pickup_fees;
                        $tax = $cost * $order->user->tax / 100;
                        $total = $cost + $tax;
                        ClientTransactionsModels::create([
                            'user_id' => $order->user_id,
                            'description' => 'تكلفه  استلام الطلبات من متجرك بمبلغ قيمته : ' . $total,
                            'creditor' => $total,
                            'order_id' => $order->id,
                            'transaction_type_id' => 6,
                        ]);
                    }

                }
            }
        }
        // fulfillment client
        elseif ($order->work_type == 4) {
            if ($order->user->cost_type == 1) {
                if ($order->status_id == $order->user->userStatus->pick_process_package_status_id) {
                    $transaction = self::checkExistingTransaction($order->id, 9);
                    if (!$transaction) {
                        $cost = $order->user->userCost->pick_process_package;
                        $tax = $cost * $order->user->tax / 100;
                        $total = $cost + $tax;
                        self::createTransaction($order->user_id, "تكلفة التقاط وتجهيز وتغليف طلب رقم : {$order->order_id}" . ' مبلغ : ' . $cost, $total, $order->id, 9);
                    }
                }

                if ($order->status_id == $order->user->userStatus->print_waybill_status_id) {
                    $transaction = self::checkExistingTransaction($order->id, 10);

                    if (!$transaction) {
                        $cost = $order->user->userCost->print_waybill;
                        $tax = $cost * $order->user->tax / 100;
                        $total = $cost + $tax;
                        self::createTransaction($order->user_id, "تكلفة طباعة بوليصة طلب رقم :  {$order->order_id}" . ' مبلغ : ' . $cost, $total, $order->id, 10);

                    }
                }

                if ($order->status_id == $order->user->userStatus->sort_by_city_status_id) {
                    $transaction = self::checkExistingTransaction($order->id, 11);
                    if (!$transaction) {
                        $cost = $order->user->userCost->sort_by_city;
                        $tax = $cost * $order->user->tax / 100;
                        $total = $cost + $tax;
                        self::createTransaction($order->user_id, "تكلفة فرز حسب المدينة طلب رقم :   {$order->order_id}" . ' مبلغ : ' . $cost, $total, $order->id, 11);

                    }
                }

                if ($order->status_id == $order->user->userStatus->store_return_shipment_status_id) {
                    $transaction = self::checkExistingTransaction($order->id, 12);

                    $transaction = ClientTransactionsModels::where('order_id', $order->id)->where('transaction_type_id', 12)->first();
                    if (!$transaction) {
                        $cost = $order->user->userCost->store_return_shipment;
                        $tax = $cost * $order->user->tax / 100;
                        $total = $cost + $tax;
                        self::createTransaction($order->user_id, "تكلفة  تخزين الشحنة المعكوسة  طلب رقم : {$order->order_id}" . ' مبلغ : ' . $cost, $total, $order->id, 12);

                    }
                }

                if ($order->status_id == $order->user->userStatus->reprocess_return_shipment_status_id) {
                    $transaction = self::checkExistingTransaction($order->id, 13);
                    if (!$transaction) {
                        $cost = $order->user->userCost->reprocess_return_shipment;
                        $tax = $cost * $order->user->tax / 100;
                        $total = $cost + $tax;
                        self::createTransaction($order->user_id, "تكلفة إعادة تجهيز الشحنة المعكوسة طلب رقم :  {$order->order_id}" . ' مبلغ : ' . $cost, $total, $order->id, 13);

                    }
                }

                if ($order->status_id == $order->user->userStatus->cost_calc_status_id && $order->sender_city == $order->receved_city) {
                    $transaction = self::checkExistingTransaction($order->id, 1);
                    if (!$transaction) {
                        if ($order->sender_city == $order->receved_city) {
                            $cost = $order->user->userCost->cost_inside_city;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                            self::createTransaction($order->user_id, "تكلفة شحن طلب رقم : {$order->order_id}" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax, $total, $order->id, 1);
                        } else {

                            $cost = $order->user->userCost->cost_outside_city;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                            self::createTransaction($order->user_id, "تكلفة شحن طلب رقم : {$order->order_id}" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax, $total, $order->id, 1);
                        }
                        CompanyTransactions::addToCompanyTransaction($order);
                    }
                }

                if ($order->status_id == $order->user->userStatus->cost_calc_status_id_outside && $order->sender_city != $order->receved_city) {
                    $transaction = self::checkExistingTransaction($order->id, 1);
                    if (!$transaction) {
                        if ($order->sender_city == $order->receved_city) {
                            $cost = $order->user->userCost->cost_inside_city;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                            self::createTransaction($order->user_id, "تكلفة شحن طلب رقم : {$order->order_id}" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax, $total, $order->id, 1);
                        } else {
                            $cost = $order->user->userCost->cost_outside_city;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                            self::createTransaction($order->user_id, "تكلفة شحن طلب رقم : {$order->order_id}" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax, $total, $order->id, 1);
                        }
                        CompanyTransactions::addToCompanyTransaction($order);

                    }
                }
                if ($order->status_id == $order->user->userStatus->cost_reshipping_calc_status_id) {
                    $transaction = ClientTransactionsModels::where('order_id', $order->id)->where('transaction_type_id', 2)->first();
                    if (!$transaction) {

                        if ($order->sender_city == $order->receved_city) {
                            $cost = $order->user->userCost->cost_reshipping;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                        } else {
                            $cost = $order->user->userCost->cost_reshipping_out_city;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                        }
                        self::createTransaction($order->user_id, "تكلفة اعادة شحن طلب رقم : {$order->order_id}" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax, $total, $order->id, 2);

                    }
                }
                if ($order->status_id == $order->user->userStatus->calc_cash_on_delivery_status_id) {
                    if ($order->amount > 0) {
                        $transaction = ClientTransactionsModels::where('order_id', $order->id)->where('transaction_type_id', 3)->first();
                        if (!$transaction) {
                            if ($order->sender_city == $order->receved_city) {
                                $fees = $order->user->userCost->fees_cash_on_delivery;
                            } else {
                                $fees = $order->user->userCost->fees_cash_on_delivery_out_city;
                            }
                            ClientTransactionsModels::create([
                                'user_id' => $order->user_id,
                                'description' => 'رسوم تحصيل مبلغ مالي للطلب رقم : ' . $order->order_id,
                                'creditor' => $fees,
                                'order_id' => $order->id,
                                'transaction_type_id' => 3,
                            ]);
                            if ($order->delegate_id) {
                                ClientTransactionsModels::create([
                                    'user_id' => $order->delegate_id,
                                    'description' => ' تحصيل مبلغ مالي للطلب رقم : ' . $order->order_id,
                                    'creditor' => $order->amount,
                                    'order_id' => $order->id,
                                    'transaction_type_id' => 4,
                                ]);
                            }

                            ClientTransactionsModels::create([
                                'user_id' => $order->user_id,
                                'description' => ' تحصيل مبلغ مالي للطلب رقم : ' . $order->order_id,
                                'debtor' => $order->amount,
                                'order_id' => $order->id,
                                'transaction_type_id' => 4,
                            ]);

                        }
                    }
                }
                if ($order->status_id == $order->user->userStatus->available_overweight_status && $order->sender_city == $order->receved_city) {
                    $transaction = ClientTransactionsModels::where('order_id', $order->id)->where('transaction_type_id', 5)->first();

                    if (!$transaction) {
                        $standard_weight = $order->user->standard_weight;

                        //over_weight_per_kilo_outside
                        if ($order->sender_city == $order->receved_city) {
                            $standard_weight = $order->user->userCost->standard_weight;
                            $over_weight_per_kilo = $order->user->userCost->over_weight_per_kilo;
                        } else {
                            $standard_weight = $order->user->userCost->standard_weight_outside;
                            $over_weight_per_kilo = $order->user->userCost->over_weight_per_kilo_outside;
                        }

                        if ($over_weight_per_kilo == null) {
                            $over_weight_per_kilo = 0;
                        }

                        if ($standard_weight == null) {
                            $standard_weight = 0;
                        }
                        if (($order->order_weight - $standard_weight) > 0) {
                            $cost = ($order->order_weight - $standard_weight) * $over_weight_per_kilo;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;

                            ClientTransactionsModels::create([
                                'user_id' => $order->user_id,
                                'description' => 'تكلفة الوزن الزائد للطلب  رقم : ' . $order->order_id . ' مبلغ : ' . $total,
                                'creditor' => $total,
                                'order_id' => $order->id,
                                'transaction_type_id' => 5,
                            ]);
                        }

                    }
                }
                if ($order->status_id == $order->user->userStatus->available_overweight_status_outside && $order->sender_city != $order->receved_city) {
                    $transaction = ClientTransactionsModels::where('order_id', $order->id)->where('transaction_type_id', 5)->first();

                    if (!$transaction) {
                        $standard_weight = $order->user->userCost->standard_weight;

                        //over_weight_per_kilo_outside
                        if ($order->sender_city == $order->receved_city) {
                            $standard_weight = $order->user->userCost->standard_weight;
                            $over_weight_per_kilo = $order->user->userCost->over_weight_per_kilo;
                        } else {
                            $standard_weight = $order->user->userCost->standard_weight_outside;
                            $over_weight_per_kilo = $order->user->userCost->over_weight_per_kilo_outside;
                        }

                        if ($over_weight_per_kilo == null) {
                            $over_weight_per_kilo = 0;
                        }

                        if ($standard_weight == null) {
                            $standard_weight = 0;
                        }
                        if (($order->order_weight - $standard_weight) > 0) {
                            $cost = ($order->order_weight - $standard_weight) * $over_weight_per_kilo;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;

                            ClientTransactionsModels::create([
                                'user_id' => $order->user_id,
                                'description' => 'تكلفة الوزن الزائد للطلب  رقم : ' . $order->order_id . ' مبلغ : ' . $total,
                                'creditor' => $total,
                                'order_id' => $order->id,
                                'transaction_type_id' => 5,
                            ]);
                        }

                    }
                }

                if ($order->status_id == $order->user->userStatus->available_collect_order_status) {
                    // echo 'here';die();
                    $dateNowSubHour = Carbon::now()->subHours(1);
                    $order_ids = ClientTransactionsModels::where('user_id', $order->user_id)->where('transaction_type_id', 6)
                        ->whereDate('created_at', '>=', $dateNowSubHour)->pluck('order_id')->toArray();

                    if (count($order_ids) > 0) {

                        $order_counts = Order::whereIn('id', $order_ids)->where('user_id', $order->user_id)->where('delegate_id', $order->delegate_id)->count();

                        if ($order_counts < 1) {
                            $cost = $order->user->userCost->pickup_fees;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;

                            ClientTransactionsModels::create([
                                'user_id' => $order->user_id,
                                'description' => 'تكلفه  استلام الطلبات من متجرك بمبلغ قيمته : ' . $total,
                                'creditor' => $total,
                                'order_id' => $order->id,
                                'transaction_type_id' => 6,
                            ]);
                        }
                    } else {
                        $cost = $order->user->userCost->pickup_fees;
                        $tax = $cost * $order->user->tax / 100;
                        $total = $cost + $tax;
                        ClientTransactionsModels::create([
                            'user_id' => $order->user_id,
                            'description' => 'تكلفه  استلام الطلبات من متجرك بمبلغ قيمته : ' . $total,
                            'creditor' => $total,
                            'order_id' => $order->id,
                            'transaction_type_id' => 6,
                        ]);
                    }

                }
                // shereen sort by sku for product
                if ($order->status_id == $order->user->userStatus->sort_by_skus_status_id) {
                    $product_count=count($order->goods);
                    if($product_count!=null)
                    {
                    $transaction = self::checkExistingTransaction($order->id, 21);
                    if (!$transaction) {
                        $cost = $order->user->userCost->sort_by_suku;
                        $total_cost=$cost*$product_count;
                        $tax = $total_cost * $order->user->tax / 100;
                        $total = $total_cost + $tax;
                        $total = round($total, 2);

                        self::createTransaction($order->user_id, "تكلفة فرز  المنتج حسب (SKU )طلب رقم :  {$order->order_id}" . ' مبلغ : ' . $total, $total, $order->id, 21);

                    }}
                }



            }
        }
        //resturant
        elseif ($order->work_type == 2) {
                if ($order->status_id == $order->user->cost_calc_status_id) {
                    $transaction = self::checkExistingTransaction($order->id, 1);
                    if (! $transaction) {
                        $cost = $order->user->cost_inside_city;
                        $tax = $cost * $order->user->tax / 100;
                        $total = $cost + $tax;
                       
                        CompanyTransactions::addToCompanyTransaction($order);
                        self::createTransaction($order->user_id, "تكلفة شحن طلب رقم : {$order->order_id}".' مبلغ : '.$cost.' + ضريبة : '.$tax, $total, $order->id, 1);

                    }
                }

                if ($order->status_id == $order->user->cost_reshipping_calc_status_id) {
                    $transaction = self::checkExistingTransaction($order->id, 2);
                    if (! $transaction) {

                        $cost = $order->user->cost_reshipping;
                        $tax = $cost * $order->user->tax / 100;
                        $total = $cost + $tax;
                        
                        self::createTransaction($order->user_id, "تكلفة اعادة شحن طلب رقم : {$order->order_id}".' مبلغ : '.$total, $total, $order->id, 2);
                    }
                }
                if (($order->status_id == $order->user->calc_cash_on_delivery_status_id) && ($order->amount_paid==0)) {
                   
                    if ($order->amount > 0) {
                        $transaction = self::checkExistingTransaction($order->id, 3);
                        if (! $transaction) {
                            
                            $fees = $order->user->fees_cash_on_delivery;
                            
                            ClientTransactionsModels::create([
                                'user_id' => $order->user_id,
                                'description' => 'رسوم تحصيل مبلغ مالي للطلب رقم : '.$order->order_id,
                                'creditor' => $fees,
                                'order_id' => $order->id,
                                'transaction_type_id' => 3,
                            ]);
                            if ($order->delegate_id) {
                                ClientTransactionsModels::create([
                                    'user_id' => $order->delegate_id,
                                    'description' => ' تحصيل مبلغ مالي للطلب رقم : '.$order->order_id,
                                    'creditor' => $order->amount,
                                    'order_id' => $order->id,
                                    'transaction_type_id' => 4,
                                ]);
                            }

                            ClientTransactionsModels::create([
                                'user_id' => $order->user_id,
                                'description' => ' تحصيل مبلغ مالي للطلب رقم : '.$order->order_id,
                                'debtor' => $order->amount,
                                'order_id' => $order->id,
                                'transaction_type_id' => 4,
                            ]);
                        }
                    }
                }
                if ($order->status_id == $order->user->available_overweight_status && ($order->amount_paid==0)) {
                    $transaction = self::checkExistingTransaction($order->id, 5);

                    if (! $transaction) {
                        $standard_weight = $order->user->standard_weight;

                        //over_weight_per_kilo_outside
                        if ($order->sender_city == $order->receved_city) {
                            $standard_weight = $order->user->standard_weight;
                            $over_weight_per_kilo = $order->user->over_weight_per_kilo;
                        } else {
                            $standard_weight = $order->user->standard_weight_outside;
                            $over_weight_per_kilo = $order->user->over_weight_per_kilo_outside;
                        }

                        if ($over_weight_per_kilo == null) {
                            $over_weight_per_kilo = 0;
                        }

                        if ($standard_weight == null) {
                            $standard_weight = 0;
                        }
                        if (($order->order_weight - $standard_weight) > 0) {
                            $cost = ($order->order_weight - $standard_weight) * $over_weight_per_kilo;
                            $tax = $cost * $order->user->tax / 100;
                            $total = $cost + $tax;
                            self::createTransaction($order->user_id, "تكلفة الوزن الزائد للطلب  رقم : {$order->order_id}".' مبلغ : '.$total, $total, $order->id, 5);
                        }

                    }
                }
        // calculate cost with distance
        // elseif ($order->work_type == 2) { 
        //     $transaction = ClientTransactionsModels::where('order_id', $order->id)->where('transaction_type_id', 1)->first();
        //         if (!$transaction) {
        //             $distance = $order->distance;
        //             $cost =  $distance * $order->user->over_weight_per_kilo;
        //             $tax = $cost * $order->user->tax / 100;
        //             $total = $cost + $tax;
        //             self::createTransaction($order->user_id, "تكلفة شحن طلب رقم : {$order->order_id}" . ' مبلغ : ' . $cost . ' + ضريبة : ' . $tax, $total, $order->id, 1);

        //         }
           

        // }
               
        } else {
            if ($order->status_id == $order->user->cost_calc_status_id) {
                $transaction = self::checkExistingTransaction($order->id, 1);
                if (! $transaction) {
                    $cost = $order->user->cost_inside_city;
                    $tax = $cost * $order->user->tax / 100;
                    $total = $cost + $tax;
                    ClientTransactionsModels::create([
                        'user_id' => $order->user_id,
                        'description' => 'تكلفة شحن طلب رقم : '.$order->order_id.' مبلغ : '.$cost.' + ضريبة : '.$tax,
                        'creditor' => $total,
                        'order_id' => $order->id,
                        'transaction_type_id' => 1,
                    ]);
                    CompanyTransactions::addToCompanyTransaction($order);
                }
            }
            if ($order->status_id == $order->user->calc_cash_on_delivery_status_id) {
                if ($order->amount > 0) {
                    $transaction = ClientTransactionsModels::where('order_id', $order->id)->where('transaction_type_id', 3)->first();
                    if (!$transaction) {
                        $fees = $order->user->fees_cash_on_delivery;

                        ClientTransactionsModels::create([
                            'user_id' => $order->user_id,
                            'description' => 'رسوم تحصيل مبلغ مالي للطلب رقم : ' . $order->order_id,
                            'creditor' => $fees,
                            'order_id' => $order->id,
                            'transaction_type_id' => 3,
                        ]);
                        if ($order->delegate_id != null) {
                            ClientTransactionsModels::create([
                                'user_id' => $order->delegate_id,
                                'description' => ' تحصيل مبلغ مالي للطلب رقم : ' . $order->order_id,
                                'creditor' => $order->amount,
                                'order_id' => $order->id,
                                'transaction_type_id' => 4,
                            ]);
                        }

                        ClientTransactionsModels::create([
                            'user_id' => $order->user_id,
                            'description' => ' تحصيل مبلغ مالي للطلب رقم : ' . $order->order_id,
                            'debtor' => $order->amount,
                            'order_id' => $order->id,
                            'transaction_type_id' => 4,
                        ]);
                    }
                }
            }
            //
            if ($order->status_id == $order->user->cost_reshipping_calc_status_id) {
                $transaction = ClientTransactionsModels::where('order_id', $order->id)->where('transaction_type_id', 2)->first();
                if (!$transaction) {

                    $cost = $order->user->cost_reshipping;
                    $tax = $cost * $order->user->tax / 100;
                    $total = $cost + $tax;

                    ClientTransactionsModels::create([
                        'user_id' => $order->user_id,
                        'description' => 'تكلفة اعادة شحن طلب رقم : ' . $order->order_id,
                        'creditor' => $total,
                        'order_id' => $order->id,
                        'transaction_type_id' => 2,
                    ]);

                    CompanyTransactions::addToCompanyTransaction($order);
                }
            }
        }
       
    }
}
