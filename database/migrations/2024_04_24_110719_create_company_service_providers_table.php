<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_service_providers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
           
            $table->unsignedBigInteger('service_provider_id');
            $table->foreign('service_provider_id')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('is_active')->default(false);
            $table->text('auth_token')->nullable(); 


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_service_providers');
    }
};
