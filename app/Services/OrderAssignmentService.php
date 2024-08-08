<?php

namespace App\Services;

use App\Helpers\Notifications;
use App\Models\Order;
use App\Models\OrderRulesDetail;
use App\Models\Orders_rules;
use App\Models\rules_order_numbers;
use App\Models\User;
use App\Traits\PushNotificationsTrait;

class OrderAssignmentService
{
    use PushNotificationsTrait;

    public function assignToDelegate($order)
    {
        $order = Order::find($order);
        // if($order->user_id == 611){
        //     $order->update(['delegate_id' => 693]);
        // }
        $rules = $this->fetchApplicableRules($order->id);

        $bestRule = $this->findBestMatchingRule($rules, $order->id);

        if ($bestRule) {
            $this->assignOrderToDelegate($order->id, $bestRule);
            $this->IncreaseOrdersRuleNumber($order->id, $bestRule->id);
            // Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : ' . $order->order_id, 'order', $bestRule->delegate_id, 'delegate', $order->id);

            if ($order->delegate_id != null) {
                $user = User::findorfail($order->delegate_id);
                $token = $user->Device_Token;
                if ($token != null) {
                    $title = 'تمت أضافة طلب جديد ';
                    $body = 'تم اضافة طلب شحن جديد الي حسابك : ' . $order->order_id;
                    // call function that will push notifications :
                    $this->sendNotification($token, $title, $body);
                }
            }

        } else {
        }

    }

    protected function fetchApplicableRules($order)
{
    $order = Order::find($order);

    // First, try to match rules with detailed conditions
    $rulesWithDetails = Orders_rules::where('company_id', $order->company_id)
        ->where('status', 1)
        ->where('work_type', $order->work_type)
        ->where('type', 1)
        ->whereHas('order_rules_details', function ($query) use ($order) {
            $query->where(function ($subQuery) use ($order) {
                $subQuery->orWhere('cod', $order->amount_paid)
                         ->orWhere('City_from', $order->address->city_id)
                         ->orWhere('city_to', $order->receved_city)
                         ->orWhere('region_from', $order->address->neighborhood_id)
                         ->orWhere('region_to', $order->region_id);
            })
            ->where('client_id', $order->user_id)
            ->where('address_id', $order->store_address_id);
        })
        ->orderBy('id', 'desc')
        ->get();

    // If no detailed rules match, then fetch rules without details
    if ($rulesWithDetails->isEmpty()) {
        $rulesWithoutDetails = Orders_rules::where('company_id', $order->company_id)
            ->where('status', 1)
            ->where('work_type', $order->work_type)
            ->where('type', 1)
            ->whereDoesntHave('order_rules_details')
            ->orderBy('id', 'desc')
            ->get();

        return $rulesWithoutDetails;
    }

    return $rulesWithDetails;
}

    protected function assignOrderToDelegate($order, $rule)
    {
        Order::where('id', $order)->update(['delegate_id' => $rule->delegate_id]);

    }

    protected function findBestMatchingRule($rules, $order)
    {
        $order = Order::find($order);

        $allDetails = OrderRulesDetail::whereIn('order_rules_id', $rules->pluck('id'))->get();

        $bestRule = null;
        $highestScore = 0;
        $lowestOrderCount = PHP_INT_MAX; // Initialize with the maximum possible value
        foreach ($rules as $i => $rule) {
            $details = $allDetails->where('order_rules_id', $rule->id);
            $score = 0;

            // Direct checks to avoid multiple pluck operations
            foreach ($details as $detail) {
                if ($detail->client_id === $order->user_id) {
                    $score++;
                }
                if ($detail->address_id === $order->store_address_id) {

                    $score++;
                }
                if ($detail->cod === $order->amount_paid) {
                    $score++;
                }
                if ($order->address && $detail->City_from === $order->address->city_id) {
                    $score++;
                }
                if ($detail->city_to === $order->receved_city) {
                    $score++;
                }
                if ($order->address && $detail->region_from === $order->address->neighborhood_id) {
                    $score++;
                }
                if ($detail->region_to === $order->region_id) {
                    $score++;
                }

            }

            // Calculate new orders count for the current rule
            $defultclientstatus = User::where('user_type', 'client')
                ->where('work', $order->work_type)
                ->where('company_id', $order->company_id)
                ->pluck('calc_cash_on_delivery_status_id')
                ->toArray();

            $currentOrderCount = Order::where('delegate_id', $rule->delegate_id)
                ->whereNotIn('status_id', $defultclientstatus)
                ->count();

            // Additional check for rule-specific conditions
            if (($rule->max > count($rule->orderNumber)) || $rule->max == null) {
                $score++;
            }

            if ($score > $highestScore) {
                $highestScore = $score;
                $lowestOrderCount = $currentOrderCount;
                $bestRule = $rule;
            } else if ($score === $highestScore) {
                if ($currentOrderCount < $lowestOrderCount) {
                    $lowestOrderCount = $currentOrderCount;
                    $bestRule = $rule;
                }
            }
        }

        return $bestRule;
    }

    protected function IncreaseOrdersRuleNumber($order_id, $rule_id)
    {
        $orderNum = new rules_order_numbers();
        $orderNum->order_id = $order_id;
        $orderNum->rule_id = $rule_id;
        $orderNum->save();

    }

    public function assignToService_Provider($order)
    {
        $order = Order::find($order);

        $rules = Orders_rules::where('type', 2)->where('status', 1)->where('work_type', $order->work_type)->where('company_id', $order->company_id)->get();
        $bestRule = null;
        $highestScore = 0;

        foreach ($rules as $rule) {
            $score = 0;

            // Direct checks to avoid multiple pluck operations
            if ($rule->client_id === $order->user_id) {
                $score++;
            }
            if ($rule->address_id === $order->store_branch_id) {
                $score++;
            }

            // Additional check for rule-specific conditions
            if (($rule->max > count($rule->orderNumber)) || $rule->max == null) {
                $score++;
            }

            if ($score > $highestScore) {
                $highestScore = $score;
                $bestRule = $rule;
            }
        }

        if ($bestRule) {
            $this->assignOrderToServiceProvider($order->id, $bestRule);
            $this->IncreaseOrdersRuleNumber($order->id, $bestRule->id);

            // Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : ' . $order->order_id, 'order', $bestRule->delegate_id, 'service provider', $order->id);
        } else {
        }
    }

    protected function assignOrderToServiceProvider($order, $bestRule)
    {

        Order::where('id', $order)->update(['service_provider_id' => $bestRule->delegate_id]);

    }
}
