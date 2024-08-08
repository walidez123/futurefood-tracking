<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE orders_rules MODIFY COLUMN work_type ENUM("client", "restaurant", "branch") NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE orders_rules MODIFY COLUMN work_type TINYINT(4) NOT NULL');
    }
};
