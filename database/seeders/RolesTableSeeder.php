<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Can ,Modify System Level Changes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Catering',
                'slug' => 'catering',
                'description' => 'Can ,Modify System Level Changes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Venu',
                'slug' => 'venu',
                'description' => 'Can ,Modify System Level Changes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chairity',
                'slug' => 'chairity',
                'description' => 'Can ,Modify System Level Changes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more user records here
        ];

        // Insert multiple records into the users table
        DB::table('roles')->insert($roles);
    }
}
