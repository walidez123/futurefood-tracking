<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate the roles table to remove existing records
        DB::table('roles')->truncate();

        // Insert roles data
        $roles = [
            ['title' => 'admin', 'company_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'editor', 'company_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'order', 'company_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'money', 'company_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Data Entery', 'company_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'restaurant dlivery', 'company_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'super admins', 'company_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'restaurant', 'company_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('roles')->insert($roles);
    }
}
