<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
      
      
      $countries = Country::factory(10)->create();
      
      // Seed 20 warehouses with random countries
      $warehouses = Warehouse::factory(20)->create([
        'country_id' => $countries->random()->id,
      ]);
      
      // Seed 30 products
      $products = Product::factory(30)->create();
      
      // Seed 15 suppliers
      Supplier::factory(15)->create();
      
      $this->call([
        InventorySeeder::class
      ]);
    }
}
