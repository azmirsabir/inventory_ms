<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
  {
    $products = Product::all();
    $warehouses = Warehouse::all();
    
    if ($products->isEmpty() || $warehouses->isEmpty()) {
      $this->command->error('Please seed products and warehouses before seeding inventories.');
      return;
    }
    
    $count = 0;
    $max = 10;
    
    foreach ($products as $product) {
      foreach ($warehouses as $warehouse) {
        if ($count >= $max) {
          return;
        }
        
        // Create inventory with unique product-warehouse pair
        Inventory::factory()->create([
          'product_id' => $product->id,
          'warehouse_id' => $warehouse->id,
          'quantity' => rand(1, 100),
          'minimum_quantity' => rand(1, 10),
          'created_at' => now(),
          'updated_at' => now(),
        ]);
        
        $count++;
      }
    }
  }
}
