<?php
  
  namespace Database\Factories;
  
  use App\Models\Country;
  use Illuminate\Database\Eloquent\Factories\Factory;
  
  /**
   * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
   */
  class CountryFactory extends Factory
  {
    protected $model = Country::class;
    
    public function definition(): array
    {
      return [
        'name' => $this->faker->unique()->country,
        'code' => strtoupper($this->faker->unique()->lexify('???')),
      ];
    }
  }
