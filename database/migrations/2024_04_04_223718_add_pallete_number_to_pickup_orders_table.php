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
        Schema::table('pickup_orders', function (Blueprint $table) {
            $table->integer('pallete_number')->nullable()->after('distance');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pickup_orders', function (Blueprint $table) {
            $table->dropColumn(['pallete_number']);
        
        });
    }
};
