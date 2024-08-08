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
            $table->string('email')->nullable()->change();
            $table->string('region_id')->nullable()->change();
            $table->string('work_type')->nullable()->change();
            $table->string('type_vehicle')->nullable()->change();
            $table->string('Num_vehicle')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_join_users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('region_id')->nullable()->change();
            $table->string('work_type')->nullable()->change();
            $table->string('type_vehicle')->nullable()->change();
            $table->string('Num_vehicle')->nullable()->change();
        });
    }
};
