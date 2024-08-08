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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('Movement')->nullable()->after('Device_Token');
            $table->integer('delivery_number')->nullable()->after('Movement');
            $table->integer('size_id')->nullable()->after('delivery_number');
            $table->integer('Cartons_number')->nullable()->after('size_id');
            $table->integer('Space')->nullable()->after('Cartons_number');
            $table->string('No_Skus', 200)->nullable()->after('Space');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('Movement');
            $table->dropColumn('delivery_number');
            $table->dropColumn('size_id');
            $table->dropColumn('Cartons_number');
            $table->dropColumn('Space');
            $table->dropColumn('No_Skus');

        });
    }
};
