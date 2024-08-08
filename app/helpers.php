<?php

use App\Models\Otp_code;
use App\Models\Order;
use App\Models\Orders_rules;
use App\Models\User;
use App\Helpers\Notifications;
use App\Models\rules_order_numbers;
use App\ProvidersIntegration\Foodics\Orders;
use App\ProvidersIntegration\Salla\UpdateOrderStatus;
use App\Services\Adaptors\Foodics\Foodics;
use App\Jobs\FoodicUpdateStatus;
use App\Helpers\ClientTransactions;
use App\Helpers\OrderHistory;
use App\Models\OrderRulesDetail;
use App\Services\Adaptors\LaBaih\LaBaih;
use App\Services\Adaptors\Aymakan\Aymakan;
use App\Models\OrderGoods;
Use App\Models\Good;
use App\Models\Client_packages_good;
use App\Models\Packages_history;
use App\Services\Adaptors\Farm\Farm;
use App\Services\Adaptors\Farm\FarmTest;



   /* ---------------------- start qr methods ----------------- */
   function __getLengtht($value)
   {
       return strlen($value);
   }

   function __toHex($value)
   {
       return pack("H*", sprintf("%02X", $value));
   }

   function __toString($__tag, $__value, $__length)
   {
       $value = (string) $__value;
       return __toHex($__tag) . __toHex($__length) . $value;
   }

   function __getTLV($dataToEncode)
   {
       $__TLVS = '';
       for ($i = 0; $i < count($dataToEncode); $i++) {
           $__tag = $dataToEncode[$i][0];
           $__value = $dataToEncode[$i][1];
           $__length = __getLengtht($__value);
           $__TLVS .= __toString($__tag, $__value, $__length);
       }

       return $__TLVS;
   }
   /*----------------------- end qr methods -------------------*/

function customRequestCaptcha(){
    return new \ReCaptcha\RequestMethod\Post();
}

function SendSMSCode($mobile, $message)
{

    $username = 'Preuimship';     // The user name of gateway
    $token = '552a6acaaf53611e74006afbdb2fcaab47c6e4cf58b7df2a6a0179335b9e09cc';
    $password = '123Hh123';           // the password of gateway
    $mobile = '966'.trim(substr($mobile, 1)); // 966500000000,966510000000
    $sender = 'Preuim ship';
    // $url                = 'https://www.sms.dreams.sa/index.php/api/sendsms/?user='.$username.'&pass='.$password.'&to='.$mobile.'&message='.$message.'&sender='.$sender;

    $url = 'https://www.dreams.sa/index.php/api/sendsms/?user='.$username.'&secret_key='.$token.'&to='.$mobile.'&message='.$message.'&sender='.$sender;
    $client = new \GuzzleHttp\Client();
    $response = $client->get($url);
    $result = json_decode($response->getBody());

    return $result;
}

function codegenerateDelegate()
{
    $code = rand(100000, 9999999);
    if (codeExistsCode($code)) {
        return codegenerateDelegate();
    }

    return $code;
}
function codeExistsCode($code)
{
    return User::whereCode($code)->exists();

}

function codegenerate()
{
    $code = rand(1000, 9999);
    if (codeExists($code)) {
        return codegenerate();
    }

    return $code;
}
function codeExists($code)
{
    // query the database and return a boolean
    // for instance, it might look like this in Laravel
    return Otp_code::whereCode($code)->exists();
}
function send_otp($order_id, $status_id, $delegate_id)
{
    $code = codegenerate();

    $create_at = time();
    $expiredDate = date('Y-m-d H:i:s', strtotime('+1 day', $create_at));

    // return $expiredDate;
    $updatedData = [
        'code' => $code,
        'validate_to' => $expiredDate,
        'order_id' => $order_id,
        'status_id' => $status_id,
        'delegate_id' => $delegate_id,
    ];
    // return $check;
    $update = Otp_code::create($updatedData);
    if ($update) {
        $order = Order::where('order_id', $order_id)->first();
        $message = " كود التأكيد الخاص بك هو $code ";
        $to = $order->receved_phone;
        SendSMSCode($to, $message);
        $notification = 'تم ارسال كود التفعيل  للعميل ';

        return $message;
    }
}
///

function GloablChangeStatus($order, $status_id, $latitude = null, $longitude = null)
{
    
    $order->update([
        'status_id' => $status_id,
    ]);
        if($order->user->id == 611 && $order->status->id == 220)  {
            if($order->payment_method != 3){$order->update(['amount_paid' => 1]);}

            FarmApi($order->reference_number);
         }
         elseif($order->user->id == 572 && $order->status->id == 220 ){
            if($order->payment_method != 3){$order->update(['amount_paid' => 1]);}

            FarmApi($order->reference_number);
         }
    ClientTransactions::addToClientTransactions($order);
    OrderHistory::addToHistory($order->id, $status_id, $note = null, $latitude, $longitude);
   
    

    
    // 
    if($order->work_type==4 && $order->status_id==$order->user->userStatus->shortage_order_quantity_f_stock)
    {
        shortage_quenteny_from_stock($order->id);
    }
    if($order->work_type==4 && $order->status_id==$order->user->userStatus->restocking_order_quantity_to_stock)
    {
        restocking_order_quantity_to_stock($order->id);
    }
    

    // 
    dispatch(new \App\Jobs\UpdateOrderStatusInProvider($order))->delay(6);
    if($order->service_provider_id !=NULL)	
    {
        if($order->service_provider->email=='labaih@future.sa')
        {
            Labaih_Apis($order,$order->service_provider);
        }

        elseif($order->service_provider->id == 568)
        {
            aymakanApis($order,$order->service_provider);
        }
        
    }

}
function Labaih_Apis($order, $service_provider_id)
{

    $company_setting = Auth()->user()->company_setting;
    // send order
    if ($company_setting->send_order_service_provider == $order->status_id && $order->work_type == 1) {

        $data = LaBaih::send_order($order);
        $data = json_decode($data->getBody(), true);
        if ($data['status'] == 200) {
            $order->update([
                'consignmentNo' => $data['consignmentNo'],
                'service_provider_id' => $service_provider_id,

            ]);
            Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : '.$order->order_id, 'order', $service_provider_id, 'service provider', $order->id);
        }
    }
    //  return order
    if ($company_setting->Return_order_service_provider == $order->status_id && $order->work_type == 1 && $order->consignmentNo != null) {
        $consignmentNo = $order->consignmentNo;

        $data = LaBaih::Return_order($consignmentNo);

    }
    //Cancel order
    if ($company_setting->cancel_order_service_provider == $order->status_id && $order->work_type == 1 && $order->consignmentNo != null) {

        $consignmentNo = $order->consignmentNo;
        $data = LaBaih::Cancel_order($consignmentNo);

    }

    function aymakanApis($order, $service_provider_id)
    {

        $company_setting = Auth()->user()->company_setting;
        // send order
        if ($company_setting->send_order_service_provider == $order->status_id && $order->work_type == 1) {

            $data = Aymakan::createShipment($order);
            $data = json_decode($data->getBody(), true);
            if ($data['status'] == 200) {

                $order->update([
                    'consignmentNo' => $data['tracking_number'],
                    'service_provider_id' => $service_provider_id

                ]);
                Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : '.$order->order_id, 'order', $service_provider_id, 'service provider', $order->id);
            }
        }
        //Cancel order
        if($company_setting->cancel_order_service_provider==$order->status_id && $order->work_type==1 && $order->tracking_number !=NULL)
        {

            $tracking_number=$order->tracking_number;
            $data=Aymakan::cancelOrder($tracking_number);
            
        }


    }
    // assign to delegate function
     function assignDelegate($order)
    {
        $order=Order::find($order);
        $Rules = Orders_rules::where('company_id', $order->company_id)->where('status', 1)->where('work_type', $order->work_type)->where('type',1)->get();
        $allDetails = OrderRulesDetail::whereIn('order_rules_id', $Rules->pluck('id'))->get();
    
        $bestRule = null;
        $highestScore = 0;
    
        foreach ($Rules as $rule) {
            $details = $allDetails->where('order_rules_id', $rule->id);
            $score = 0;
    
            // Direct checks to avoid multiple pluck operations
            foreach ($details as $detail) {
                if ($detail->client_id === $order->user_id) $score++;
                if ($detail->address_id === $order->store_branch_id) $score++;
                if ($detail->cod === $order->amount_paid) $score++;
                if ($order->address && $detail->City_from === $order->address->city_id) $score++;
                if ($detail->city_to === $order->receved_city) $score++;
                if ($order->address && $detail->region_from === $order->address->neighborhood_id) $score++;
                if ($detail->region_to === $order->region_id) $score++;
            }
    
            // Additional check for rule-specific conditions
            if ($rule->max > count($rule->orderNumber)) $score++;
    
            if ($score > $highestScore) {
                $highestScore = $score;
                $bestRule = $rule;
            }
        }



        if ($bestRule) {
            $order->delegate_id=$bestRule->delegate_id;
            $order->save();
            $orderNum = new rules_order_numbers();
            $orderNum->order_id = $order->id;
            $orderNum->rule_id = $bestRule->id;
            $orderNum->save();
              Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : ' . $order->order_id, 'order', $bestRule->delegate_id, 'delegate', $order->id);

       }
    }

  



     function assignService_Provider($order)
    {
        $order=Order::find($order);

        $rules = Orders_rules::where('type',2)->where('status',1)->where('work_type',$order->work_type)->where('company_id',Auth()->user()->company_id)->get();
        $bestRule = null;
        $highestScore = 0;

    
        foreach ($rules as $rule)
         {
            $score = 0;
    
            // Direct checks to avoid multiple pluck operations
                if ($rule->client_id === $order->user_id) $score++;
                if ($rule->address_id === $order->store_branch_id) $score++;
            
    
            // Additional check for rule-specific conditions
            if ($rule->max > count($rule->orderNumber)) $score++;
    
            if ($score > $highestScore) {
                $highestScore = $score;
                $bestRule = $rule;
            }
         }
        if ($bestRule) {
            $order->service_provider_id=$bestRule->delegate_id;
            $order->save();
            $orderNum = new rules_order_numbers();
            $orderNum->order_id = $order->id;
            $orderNum->rule_id = $bestRule->id;
            $orderNum->save();
            Notifications::addNotification('طلب شحن جديد', 'تم اضافة طلب شحن جديد الي حسابك : ' . $order->order_id, 'order', $bestRule->delegate_id, 'service provider', $order->id);
        } else {
        }

    }

     function shortage_quenteny_from_stock($orderID)
    {
        $order=Order::findOrFail(($orderID));
        $OrderGoods=OrderGoods::where('order_id',$order->id)->get();
        foreach ($OrderGoods as $i => $OrderGood) {
                        $good = Good::find($OrderGood->good_id);
                            // تحديد الكمية المطلوبة من الطلب
                            $requiredQuantity = $OrderGood->number;
    
                            // استرجاع الحزم بترتيب تصاعدي للعدد
                            $packages = Client_packages_good::where('good_id', $good->id)
                                ->where('client_id', $order->user_id)
                                ->orderBy('number', 'ASC')
                                ->get();
    
                            foreach ($packages as $package) {
                                // إذا كانت الكمية المطلوبة أكبر من 0
                                if ($requiredQuantity > 0) {
                                    // حساب الفرق بين الكمية الموجودة في الحزمة والكمية المطلوبة
                                    $difference = $package->number - $requiredQuantity;
                                    if ($difference >= 0) {
                                        // إذا كان الفرق أكبر من أو يساوي 0، تحديث عدد الحزمة وتقليل الكمية المطلوبة إلى 0
                                        $package->number = $difference;
                                        $Packages_historiy=new Packages_history();
                                        $Packages_historiy->Client_packages_good=$package->id;
                                        $Packages_historiy->number=$requiredQuantity;
                                        $Packages_historiy->type=2;
                                        $Packages_historiy->order_id=$order->id;
                                        $Packages_historiy->user_id=Auth()->user()->id;
                                        $Packages_historiy->save();
                                        $requiredQuantity = 0;

                                    } else {
                                        // إذا كان الفرق سالبًا، تقليل الكمية المطلوبة وتحديث عدد الحزمة إلى 0
                                        $Packages_historiy=new Packages_history();
                                        $Packages_historiy->Client_packages_good=$package->id;
                                        $Packages_historiy->number=$package->number;
                                        $Packages_historiy->type=2;
                                        $Packages_historiy->order_id=$order->id;
                                        $Packages_historiy->user_id=Auth()->user()->id;
                                        $Packages_historiy->save();
                                        $requiredQuantity -= $package->number;
                                        $package->number = 0;

                                        // calculate expired date for subscription for pallet
                                    }
                                    $package->save();
                                 
                                } else {
                                    // إذا تم استيفاء الكمية المطلوبة، الخروج من الحلقة
                                    break;
                                }
                            }
                        // }
                        //
                        if ($packages->sum('number') <= 5) {
                            Notifications::addNotification('أوشك على النفاذ'.$good->title_en.'|'.$good->SKUS, 'يرجى اعادة شحن و تخزين المنتج: '.$good->title_en.'|'.$good->SKUS, 'good', $order->user_id, 'client');
                        }
                        if ($packages->sum('number') == 0) {
                            Notifications::addNotification('تم نفاذ المنتج'.$good->title_en.'|'.$good->SKUS, ' تم نفاذ المنتج من المخزن: '.$good->title_en.'|'.$good->SKUS, 'good', $order->user_id, 'client');
    
                        }
                    }
    }

    function restocking_order_quantity_to_stock($orderID){
        $order=Order::findOrFail(($orderID));
        $OrderGoods=OrderGoods::where('order_id',$order->id)->get();
        foreach ($OrderGoods as $i => $OrderGood) {
                        $good = Good::find($OrderGood->good_id);
                            // تحديد الكمية المطلوبة من الطلب
                            $requiredQuantity = $OrderGood->number;
    
                            // استرجاع الحزم بترتيب تصاعدي للعدد
                            $packages = Client_packages_good::where('good_id', $good->id)
                                ->where('client_id', $order->user_id)
                                ->orderBy('number', 'ASC')
                                ->get();
    
                            foreach ($packages as $package) {
                                $history=Packages_history::where('Client_packages_good',$package->id)->where('order_id',$order->id)->where('type',2)->first();
                               

                                    if ($history!=null) {
                                        $package->number =$package->number+ $history->number;
                                        $package->save();
                                        $Packages_historiy=new Packages_history();
                                        $Packages_historiy->Client_packages_good=$package->id;
                                        $Packages_historiy->number=$history->number;
                                        $Packages_historiy->type=3;
                                        $Packages_historiy->order_id=$order->id;
                                        $Packages_historiy->user_id=Auth()->user()->id;
                                        $Packages_historiy->save();
                                    //   Notifications::addNotification('  تمت إعادة'.$good->title_en.'|'.$good->SKUS, ' إلى المخزن'.$good->title_en.'|'.$good->SKUS, 'good', $order->user_id, 'client');
                                    
                                    }
                      
                      
                        
                    }
                }

    }


    // end
}



 function FarmApi($reference_number)
    {

        try {
            $response = Farm::changeOrderStatusToDeliverd($reference_number);
            $data = json_decode($response, true);

            // Check if the operation was successful
            if(isset($data['status']) && isset($data['status']['success']) && $data['status']['success'] === false) {

                $errorMessage = $data['status']['otherTxt'];

                return response()->json([
                        'success' => 0,
                        'message' =>  'Farm API request failed: '. $errorMessage,
                    ]
                );
               
            } else {
                Log::info('farm order change status to delivered: ' . $reference_number);
            }

        } catch (RequestException $e) {
                return response()->json([
                        'success' => 0,
                        'message' => __('Farm API request failed'),
                    ]
                );
            
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'message' => __('Farm API request failed'),
            ]
        );
        }
       
    }



    function FarmApiTest($reference_number)
    {

        try {
            $response = FarmTest::changeOrderStatusToDeliverd($reference_number);
            $data = json_decode($response, true);

            // Check if the operation was successful
            if(isset($data['status']) && isset($data['status']['success']) && $data['status']['success'] === false) {
                $order = Order::where('order_id', $reference_number)->first();
                $order->update(['amount_paid' => 1]);

                $errorMessage = $data['status']['otherTxt'];

                return response()->json([
                        'success' => 0,
                        'message' =>  'Farm API request failed: '. $errorMessage,
                    ]
                );
               
            } else {
                Log::info('farm order change status to delivered: ' . $reference_number);
                Log::info('farm order change status to delivered: ' . $response);
            }

        } catch (RequestException $e) {
                return response()->json([
                        'success' => 0,
                        'message' => __('Farm API request failed'),
                    ]
                );
            
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'message' => __('Farm API request failed'),
            ]
        );
        }
       
    }