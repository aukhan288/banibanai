<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storeTypes = [
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
            ]
        ];

        // Insert multiple records into the users table
        DB::table('store_types')->insert($storeTypes);
    }
}
