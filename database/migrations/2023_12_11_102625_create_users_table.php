<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id')->nullable();
            $table->string('code', 100)->nullable();
            $table->integer('company_active')->default(1);
            $table->string('avatar')->nullable()->default('avatar/avatar.png');
            $table->string('name');
            $table->enum('user_type', ['admin', 'client', 'delegate', 'supervisor', 'service_provider', 'super_admin'])->default('client');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token', 100)->nullable()->unique();
            $table->string('domain')->nullable()->unique();
            $table->string('reset_code')->nullable();
            $table->timestamp('code_expired_at')->nullable();
            $table->string('store_name')->nullable();
            $table->string('logo')->default('logo/default.png');
            $table->unsignedBigInteger('city_id')->nullable()->index('users_city_id_foreign');
            $table->integer('region_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->integer('vehicle_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_swift')->nullable();
            $table->decimal('cost_inside_city')->nullable();
            $table->decimal('cost_outside_city')->nullable();
            $table->decimal('cost_reshipping')->nullable();
            $table->float('cost_reshipping_out_city', 10, 0)->nullable();
            $table->decimal('fees_cash_on_delivery')->nullable();
            $table->float('fees_cash_on_delivery_out_city', 10, 0)->nullable();
            $table->integer('available_collect_order_status')->nullable();
            $table->float('standard_weight', 10, 0)->nullable();
            $table->bigInteger('standard_weight_outside')->nullable();
            $table->integer('cost_calc_status_id_outside')->nullable();
            $table->string('tax')->nullable();
            $table->string('tax_Number', 200)->nullable();
            $table->integer('is_email_order')->nullable();
            $table->float('over_weight_per_kilo', 10, 0)->nullable();
            $table->integer('available_overweight_status_outside')->nullable();
            $table->integer('calc_cash_on_delivery_status_id_outside')->nullable();
            $table->bigInteger('over_weight_per_kilo_outside')->nullable();
            $table->float('pickup_fees', 10, 0)->nullable();
            $table->string('tracking_number_characters', 4)->default('SHI');
            $table->unsignedBigInteger('default_status_id')->nullable()->index('users_default_status_id_foreign');
            $table->unsignedBigInteger('cost_calc_status_id')->nullable()->index('users_cost_calc_status_id_foreign');
            $table->unsignedBigInteger('cost_reshipping_calc_status_id')->nullable()->index('users_cost_reshipping_calc_status_id_foreign');
            $table->unsignedBigInteger('calc_cash_on_delivery_status_id')->nullable()->index('users_calc_cash_on_delivery_status_id_foreign');
            $table->unsignedBigInteger('available_edit_status')->nullable()->index('users_available_edit_status_foreign');
            $table->bigInteger('available_overweight_status')->nullable();
            $table->unsignedBigInteger('available_delete_status')->nullable()->index('users_available_delete_status_foreign');
            $table->boolean('read_terms')->default(false);
            $table->rememberToken();
            $table->unsignedBigInteger('role_id')->nullable()->index('users_role_id_foreign');
            $table->string('provider', 225);
            $table->string('merchant_id', 255);
            $table->string('client_name', 255);
            $table->string('client_email', 255);
            $table->string('client_mobile', 255)->nullable();
            $table->string('provider_store_owner_name', 255);
            $table->string('provider_store_id', 255);
            $table->string('provider_store_name', 255);
            $table->string('provider_access_token', 255);
            $table->string('provider_refresh_token', 255);
            $table->string('provider_access_expiry', 255);
            $table->integer('Payment_period')->nullable()->comment('1-يومى
2-اسبوعى
3-شهرى');
            $table->integer('work')->nullable()->comment('2-طرود 1- طلبات	');
            $table->integer('work_type')->nullable()->comment('1-دوام كلى 2-دوام جزئى 3-بالطلب	');
            $table->decimal('payment', 10, 0)->nullable()->comment('سعر الطلب الواحد	');
            $table->string('Residency_number', 50)->nullable()->comment('رقم الاقامة	');
            $table->date('date')->nullable()->comment('تاريخ التعين	');
            $table->integer('manger_name')->nullable()->comment('اسم المشرف');
            $table->integer('service_provider')->nullable()->comment('الشركات المشغلة ');
            $table->string('license_photo', 200)->nullable()->comment('الرخصة');
            $table->string('residence_photo', 200)->nullable()->comment('صوره الأقامة');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('is_active')->default(true);
            $table->integer('num_branches')->nullable();
            $table->string('Tax_certificate', 200)->nullable()->comment('الشهادة الضريبة');
            $table->string('commercial_register', 200)->nullable()->comment('السجل التجارى');
            $table->integer('show_report')->default(0)->comment('0 not show 
1 show');
            $table->integer('is_company')->default(0);
            $table->integer('status_pickup')->nullable();
            $table->integer('status_pickup_res')->nullable();
            $table->text('Device_Token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
