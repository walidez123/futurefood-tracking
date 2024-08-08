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
        Schema::table('request_join_users', function (Blueprint $table) {
            $table->string('nationality', 200)->nullable()->after('email');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_join_users', function (Blueprint $table) {
            $table->dropColumn(['nationality']);

        });
    }
};
