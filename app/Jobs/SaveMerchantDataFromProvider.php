<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\Adaptors\MerchantDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Company_provider;
use App\Models\UserCost;
use App\Models\UserStatus;
use App\Models\Status;


class SaveMerchantDataFromProvider implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $merchantDetails;
    protected $app_id;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MerchantDetails $merchantDetails,$app_id = null)
    {
        $this->merchantDetails = $merchantDetails;
        $this->app_id=$app_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::where('email', $this->merchantDetails->getEmail())->first();
        $work=$this->merchantDetails->getStoreType();

        $company_id = 2;
        if ($this->merchantDetails->getProvider() == 'salla' &&  $this->app_id) {
            $config = Company_provider::where("app_id", $this->app_id)->where('provider_name','salla')->first();
            if ($config) {
                if ($config->app_type == 4) {
                    $work = 4;
                }else{
                    $work=1;
                }
                $company_id = $config->user_id;
            }

        } elseif ($this->merchantDetails->getProvider() == 'foodics') {
            $company_id = 2;

        }
        if (is_null($user)) {
           $user= User::create([
                'avatar' => $this->merchantDetails->getAvatar(),
                'name' => $this->merchantDetails->getName(),
                'user_type' => 'client',
                'email' => $this->merchantDetails->getEmail(),
                'email_verified_at' => now(),
                'password' => Str::random(10),
                'domain' => $this->merchantDetails->getWebsite(),
                'store_name' => $this->merchantDetails->getStoreName(),
                'logo' => $this->merchantDetails->getAvatar(),
                'phone' => $this->merchantDetails->getPhone(),
                'website' => $this->merchantDetails->getWebsite(),
                'provider' => $this->merchantDetails->getProvider(),
                'merchant_id' => $this->merchantDetails->getMerchantId(),
                'client_name' => $this->merchantDetails->getName(),
                'client_email' => $this->merchantDetails->getEmail(),
                'client_mobile' => $this->merchantDetails->getPhone(),
                'provider_store_owner_name' => $this->merchantDetails->getStoreOwnerName(),
                'provider_store_id' => $this->merchantDetails->getMerchantId(),
                'provider_store_name' => $this->merchantDetails->getStoreName(),
                'provider_access_token' => $this->merchantDetails->getAccessToken(),
                'provider_refresh_token' => $this->merchantDetails->getRefreshToken(),
                'provider_access_expiry' => $this->merchantDetails->getAccessExpire(),
                'company_id' => $company_id,
                'work' => $work,
            ]);
            // if($work==1||$work==4)

            if($work==4)
            {
                $user_cost = UserCost::create([
                    'user_id' => $user->id,
                    'cost_inside_city' => 1,
                    'cost_outside_city' =>1,
                    'cost_reshipping' => 1,
                    'cost_reshipping_out_city' => 1,
                    'fees_cash_on_delivery' => 1,
                    'fees_cash_on_delivery_out_city' => 1,
                    'pickup_fees' => 1,
                    'over_weight_per_kilo' => 1,
                    'over_weight_per_kilo_outside' => 1,
                    'standard_weight' => 1,
                    'standard_weight_outside' => 1,
                    'receive_palette' =>1,
                    'store_palette' =>1,
                    'pallet_subscription_type' => 1,
                    'sort_by_suku' => 1,
                    'pick_process_package' => 1,
                    'print_waybill' => 1,
                    'sort_by_city' => 1,
                    'store_return_shipment' => 1,
                    'reprocess_return_shipment' => 1,
                    'kilos_number' => 1,
                    'additional_kilo_price' => 1,
                ]);
                if($work==1)
                {
                    $status_id=Status::where('company_id',$company_id)->where('shop_appear',1)->first();

                }elseif($work==4){
                    $status_id=Status::where('company_id',$company_id)->where('fulfillment_appear',1)->first();

                }
                try {
                    $data = [
                        'user_id' => $user->id,
                        'default_status_id' => $status_id->id,
                        'available_edit_status' => $status_id->id,
                        'available_delete_status' => $status_id->id,
                        'available_collect_order_status' => $status_id->id,
                        'available_overweight_status' => $status_id->id,
                        'available_overweight_status_outside' => $status_id->id,
                        'calc_cash_on_delivery_status_id' => $status_id->id,
                        'cost_calc_status_id_outside' => $status_id->id,
                        'cost_calc_status_id' => $status_id->id,
                        'cost_reshipping_calc_status_id' => $status_id->id,
                        'receive_palette_status_id' => $status_id->id,
                        'store_palette_status_id' => $status_id->id,
                        'sort_by_skus_status_id' => $status_id->id,
                        'pick_process_package_status_id' => $status_id->id,
                        'print_waybill_status_id' => $status_id->id,
                        'sort_by_city_status_id' => $status_id->id,
                        'store_return_shipment_status_id' => $status_id->id,
                        'reprocess_return_shipment_status_id' => $status_id->id,
                        'shortage_order_quantity_f_stock' => $status_id->id,
                    ];
                
                    // Log the data before attempting to create
                    Log::info('Attempting to create UserStatus with data:', $data);
                
                    // Attempt to create the UserStatus record
                    $user_status = UserStatus::create($data);
                
                    // Log the result after creation
                    Log::info('UserStatus created successfully:', ['id' => $user_status->id]);
                } catch (\Exception $e) {
                    // Log any exceptions that occur
                    Log::error('Error creating UserStatus:', [
                        'error' => $e->getMessage(),
                        'data' => $data
                    ]);
                }


            }
        } else {
            $user->provider_access_token = $this->merchantDetails->getAccessToken();
            $user->save();
          
          
        }

    }
}