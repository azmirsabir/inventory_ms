<?php
  
  namespace Database\Factories;
  
  use App\Models\Product;
  use Illuminate\Database\Eloquent\Factories\Factory;
  
  /**
   * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
   */
  class ProductFactory extends Factory
  {
    protected $model = Product::class;
    
    public function definition(): array
    {
      return [
        'name' => $this->faker->word,
        'sku' => strtoupper($this->faker->unique()->bothify('SKU-####')),
        'status' => $this->faker->randomElement(['active', 'inactive']),
        'description' => $this->faker->sentence,
        'price' => $this->faker->randomFloat(2, 1, 500),
      ];
    }
  }
