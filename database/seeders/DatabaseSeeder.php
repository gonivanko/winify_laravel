<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $gonivanko = User::factory()->create([
            'name' => 'gonivanko',
            'email' => 'gonivanko@gmail.com',
            'password' => 'gonivanko',
            'is_admin' => '1'
        ]);

        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin',
            'is_admin' => '1'
        ]);

        $ivan = User::factory()->create([
            'name' => 'Ivan',
            'email' => 'ivan@gmail.com',
            'password' => 'ivan',
            'is_admin' => '0'
        ]);

        $yehor = User::factory()->create([
            'name' => 'Yehor',
            'email' => 'yehor@gmail.com',
            'password' => 'yehor',
            'is_admin' => '0'
        ]);


        Product::factory(20)->create([
            'seller_id' => $ivan->id
        ]);

        Product::factory(20)->create([
            'seller_id' => $yehor->id
        ]);
    }
}
