<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storeTypes = [
            [
                'name' => 'Pending',
                'color' => '#feff49',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Approved',
                'color' => '#00ff40',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rejected',
                'color' => '#e50000',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert multiple records into the users table
        DB::table('store_statuses')->insert($storeTypes);
    }
}
