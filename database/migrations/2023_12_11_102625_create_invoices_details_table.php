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
        Schema::create('invoices_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('InvoceNum', 200);
            $table->integer('client_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('allcostfess', 10, 0);
            $table->decimal('allreturnCost', 10, 0);
            $table->decimal('shippingCost', 10, 0);
            $table->decimal('tax', 10, 0);
            $table->decimal('totaltax', 10, 0);
            $table->decimal('Glopaltotal', 10, 0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
            $table->integer('company_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices_details');
    }
};
