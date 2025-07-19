<?php
  
  namespace Database\Factories;
  
  use App\Models\Inventory;
  use App\Models\Product;
  use App\Models\Warehouse;
  use Illuminate\Database\Eloquent\Factories\Factory;
  
  /**
   * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
   */
  class InventoryFactory extends Factory
  {
    protected $model = Inventory::class;
    
    public function definition(): array
    {
      return [
        'product_id' => Product::factory(),
        'warehouse_id' => Warehouse::factory(),
        'quantity' => $this->faker->numberBetween(10, 100),
        'minimum_quantity' => $this->faker->numberBetween(1, 10),
      ];
    }
  }
