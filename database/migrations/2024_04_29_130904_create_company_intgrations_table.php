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
        Schema::create('company_providers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('provider_name');
            $table->string('client_id')->nullable();
            $table->string('client_secrete')->nullable();
            $table->text('auth_base_url')->nullable();
            $table->text('base_url')->nullable();
            $table->text('tag_name')->nullable();
            $table->integer('active')->default(0);
            $table->string('app_id')->nullable();
            $table->integer('app_type')->defult(1); 
            $table->text('SALLA_WEBHOOK_CLIENT_SECRET')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_providers');
    }
};
