<?php
  
  namespace Tests\Unit;
  
  use App\Models\Country;
  use App\Services\Interface\ICountryService;
  use Illuminate\Foundation\Testing\RefreshDatabase;
  use PHPUnit\Framework\TestCase;
  
  class CountryTest extends TestCase
  {
    use RefreshDatabase;
    protected $countryService;
    
    protected function setUp(): void
    {
      parent::setUp();
      $this->service = app(ICountryService::class);
    }
    
    /**
     * A basic unit test example.
     */
    public function test_create_country()
    {
      $data = ['name' => 'Kurdistan', 'code' => 'KRD'];
      
      $country = $this->service->createCountry($data);
      
      $this->assertEquals('KRD', $country->code);
    }
    
    public function test_get_country_by_id()
    {
      $created = Country::factory()->create(['name' => 'Iraq', 'code' => 'IRQ']);
      
      $result = $this->service->getCountryById($created->id);
      
      $this->assertEquals('Iraq', $result->name);
    }
  }
