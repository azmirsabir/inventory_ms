<?php
  
  namespace Database\Factories;
  
  use App\Models\Supplier;
  use Illuminate\Database\Eloquent\Factories\Factory;
  
  /**
   * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
   */
  class SupplierFactory extends Factory
  {
    protected $model = Supplier::class;
    
    public function definition(): array
    {
      return [
        'name' => $this->faker->company,
        'contact_info' => [
          'email' => $this->faker->companyEmail,
          'phone' => $this->faker->phoneNumber,
        ],
        'address' => $this->faker->address,
      ];
    }
  }
