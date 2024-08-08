<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar', 'name', 'user_type', 'email', 'password', 'store_name', 'pickup_fees', 'over_weight_per_kilo_outside', 'cost_calc_status_id_outside',
        'logo', 'signed_contract', 'phone', 'website', 'bank_name', 'bank_account_number', 'standard_weight_outside', 'available_overweight_status_outside',
        'bank_swift', 'cost_inside_city', 'cost_outside_city', 'cost_reshipping', 'fees_cash_on_delivery', 'cost_reshipping_out_city', 'over_weight_per_kilo',
        'tax', 'tracking_number_characters', 'default_status_id', 'cost_calc_status_id', 'city_id',
        'cost_reshipping_calc_status_id', 'available_edit_status', 'available_delete_status', 'fees_cash_on_delivery_out_city', 'read_terms',
        'role_id', 'calc_cash_on_delivery_status_id', 'domain', 'available_overweight_status', 'standard_weight', 'available_collect_order_status',
        'merchant_id', 'provider', 'client_name', 'client_email', 'client_mobile', 'provider_store_owner_name',
        'provider_store_id', 'provider_store_name', 'provider_access_token', 'provider_refresh_token', 'work', 'work_type', 'payment', 'residence_photo', 'license_photo', 'vehicle_id',
        'service_provider', 'date', 'Residency_number', 'cost_type', 'kilos_number', 'additional_kilo_price', 'reset_code',
        'provider_access_expiry', 'is_active', 'region_id', 'Payment_period', 'tax_Number', 'commercial_register', 'Tax_certificate', 'num_branches',
        'show_report', 'code', 'company_id', 'company_active', 'is_company', 'status_pickup', 'status_pickup_res', 'Device_Token', 'webhook_url',
    ];

    public function getOverWeightPerKiloOutsideAttribute($value)
    {
        // condiotn for published date is null
        if ($value == null) {
            $value = 0.0;
        }

        return $value;
    }

    public function getOverWeightPerKiloAttribute($value)
    {
        // condiotn for published date is null
        if ($value == null) {
            $value = 0.0;
        }

        return $value;
    }

    public function company_setting()
    {
        return $this->belongsTo(Company_setting::class, 'company_id', 'company_id');

    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');

    }

    public function getCostReshippingOutCityAttribute($value)
    {
        // condiotn for published date is null
        if ($value == null) {
            $value = 0.0;
        }

        return $value;
    }

    public function getFeesCashOnDeliveryAttribute($value)
    {
        // condiotn for published date is null
        if ($value == null) {
            $value = 0.0;
        }

        return $value;
    }

    public function getPickupFeesAttribute($value)
    {
        // condiotn for published date is null
        if ($value == null) {
            $value = 0.0;
        }

        return $value;
    }

    public function getStandardWeightAttribute($value)
    {
        // condiotn for published date is null
        if ($value == null) {
            $value = 0.0;
        }

        return $value;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'region_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function Service_providerDelegate()
    {
        return $this->hasMany(User::class, 'service_provider');
    }

    public function transactions()
    {
        return $this->hasMany(ClientTransactions::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    //

    public function works()
    {
        return $this->hasMany(Company_work::class, 'company_id');
    }

    public function user_works()
    {
        return $this->hasMany(User_work::class, 'user_id');
    }

    //
    public function ordersDelegate()
    {
        return $this->hasMany(Order::class, 'delegate_id');
    }

    public function ordersDelegatepickup()
    {
        return $this->hasMany(Order::class, 'assign_pickup');
    }

    public function SupervisorDelegate()
    {
        return $this->hasMany(Delegate_Manger::class, 'manger_id');
    }

    public function Supervisors()
    {
        return $this->hasMany(Delegate_Manger::class, 'delegate_id');
    }

    public function companyCost()
    {
        return $this->hasone(CompanyCost::class);
    }

    public function userCost()
    {
        return $this->hasone(UserCost::class);
    }

    public function userStatus()
    {
        return $this->hasone(UserStatus::class);
    }

    public function transferClient()
    {
        return $this->hasone(UserStatus::class);
    }

    public function companyWorks()
    {
        return $this->hasMany(Company_work::class, 'company_id');
    }

    // CompanyFoodicsStatus

    public function companyFoodicsStatus()
    {
        return $this->hasOne(CompanyFoodicsStatus::class);
    }

    public function companySallaStatus()
    {
        return $this->hasOne(CompanySallaStatus::class);
    }
    public function CompanyZidStatus()
    {
        return $this->hasOne(CompanyZidStatus::class);
    }

    public function CompanyAymakanStatus()
    {
        return $this->hasOne(CompanyAymakanStatus::class);
    }

    public function companyProviderStatuses()
    {
    return $this->hasMany(CompanyProviderStatuses::class);
    }

    public function Client_packages_goods()
    {
        return $this->hasMany(Client_packages_good::class, 'client_id');
    }
    public function delegate_work()
    {
        return $this->hasMany(Delegate_work::class, 'delegate_id');
    }

    public function ServiceProviderCost()
    {
        return $this->hasOne(ServiceProviderCost::class);
   
    }

    public function companyServiceProviders()
    {
        return $this->hasMany(CompanyServiceProvider::class, 'company_id');
    }
    

}
