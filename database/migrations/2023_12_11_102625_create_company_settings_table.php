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
        Schema::create('company_settings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('logo', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('phone', 200)->nullable();
            $table->string('address', 200)->nullable();
            $table->integer('status_pickup')->nullable();
            $table->integer('status_pickup_res')->nullable();
            $table->integer('status_return_shop')->nullable();
            $table->integer('status_return_res')->nullable();
            $table->integer('status_can_return_shop')->nullable();
            $table->integer('status_can_return_res')->nullable();
            $table->integer('status_shop')->nullable();
            $table->integer('status_res');
            $table->text('terms_en')->nullable();
            $table->text('terms_ar')->nullable();
            $table->text('term_en_res')->nullable();
            $table->text('term_ar_res')->nullable();
            $table->text('term_delegate_shop_en')->nullable();
            $table->text('term_delegate_shop_ar')->nullable();
            $table->text('term_delegate_res_en')->nullable();
            $table->text('term_delegate_res_ar')->nullable();
            $table->text('token')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('sms_username', 100);
            $table->string('sms_password', 100);
            $table->string('sms_mobile', 100);
            $table->string('sms_sender_name', 100);
            $table->text('what_up_message')->nullable();
            $table->text('what_up_message_ar')->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_settings');
    }
};
