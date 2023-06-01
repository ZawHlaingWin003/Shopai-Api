<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\OrderStatus;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $order_statuses = ['Pending', 'Shipped', 'Cancelled'];
        foreach ($order_statuses as $order_status) {
            OrderStatus::create([
                'name' => $order_status
            ]);
        }

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            UserSeeder::class
        ]);
    }
}
