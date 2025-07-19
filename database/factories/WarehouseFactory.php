<?php
  
  namespace Database\Factories;
  
  use App\Models\Country;
  use App\Models\Warehouse;
  use Illuminate\Database\Eloquent\Factories\Factory;
  
  /**
   * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
   */
  class WarehouseFactory extends Factory
  {
    protected $model = Warehouse::class;
    
    public function definition(): array
    {
      return [
        'name' => 'Warehouse ' . $this->faker->unique()->word,
        'location' => $this->faker->city,
        'country_id' => Country::factory(),
      ];
    }
  }
