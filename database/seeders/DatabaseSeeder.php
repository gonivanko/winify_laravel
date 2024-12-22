<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // Product::create([
        //     'title' => 'Vintage Coca-Cola soda machine',
        //     'description' => 'A vintage Coca-Cola soda vending machine from the 1948 offers a nostalgic glimpse into classic Americana. With its iconic red design, original branding, and retro mechanics, this collectible item captures the essence of mid-20th-century soda culture. It’s a popular piece for vintage enthusiasts and adds authentic charm to any space, making it a prized possession for collectors of Coca-Cola memorabilia.',
        //     'min_bid' => 4000,
        //     'bid_step' => 100,
        //     'location' => 'Kyiv',
        //     'condition' => 'used',
        //     'starting_date' => '2024-12-02 01:30:00',
        //     'ending_date' => '2024-12-02 02:30:00',
        //     'photo' => 'photos/photo1'
        // ]);
    }
}
