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
        Schema::table('orders_rules', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('user')->after('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders_rules', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
        });
    }
};
