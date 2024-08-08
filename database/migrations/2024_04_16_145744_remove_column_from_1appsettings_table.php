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
        Schema::table('app_settings', function (Blueprint $table) {
            $table->dropColumn(['terms_en', 'terms_ar', 'term_en_res', 'term_ar_res', 'term_en_d_2', 'term_ar_d_2']);



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            $table->string('terms_en')->nullable();
            $table->string('terms_ar')->nullable();
            $table->string('term_en_res')->nullable();
            $table->string('term_ar_res')->nullable();
            $table->string('term_en_d_2')->nullable();
            $table->string('term_ar_d_2')->nullable();
                });
    }
};
