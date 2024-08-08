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
        Schema::table('company_settings', function (Blueprint $table) {
            $table->text('term_en_fulfillment')->nullable()->after('term_ar_warehouse');
            $table->text('term_ar_fulfillment')->nullable()->after('term_en_fulfillment');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn('term_en_fulfillment', 'term_ar_fulfillment');

        });
    }
};
