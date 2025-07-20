<?php
  
  namespace Tests\Unit;
  
  use App\Exceptions\NotFoundException;
  use App\Models\Country;
  use App\Services\Interface\ICountryService;
  use Illuminate\Foundation\Testing\RefreshDatabase;
  use Mockery;
  use Tests\TestCase;
  
  class CountryTest extends TestCase
  {
    use RefreshDatabase;
    
    protected $mock;
    
    protected function setUp(): void
    {
      parent::setUp();
      
      $this->mock = Mockery::mock(ICountryService::class);
      $this->app->instance(ICountryService::class, $this->mock);
    }
    
    public function tearDown(): void
    {
      Mockery::close();
      parent::tearDown();
    }
    
    public function test_create_country()
    {
      $data = ['name' => 'Kurdistan', 'code' => 'KRD'];
      
      $country = new Country($data);
      
      $this->mock->shouldReceive('createCountry')
        ->once()
        ->with($data)
        ->andReturn($country);
      
      $service = $this->app->make(ICountryService::class);
      
      $result = $service->createCountry($data);
      
      $this->assertEquals('KRD', $result->code);
    }
    
    public function test_get_country_by_id()
    {
      $country = new Country(['name' => 'Kurdistan', 'code' => 'KRD']);
      
      $this->mock->shouldReceive('getCountryById')
        ->once()
        ->with(1)
        ->andReturn($country);
      
      $result = $this->app->make(ICountryService::class)->getCountryById(1);
      
      $this->assertEquals('Kurdistan', $result->name);
    }
    
    public function test_update_country()
    {
      $country = new Country(['name' => 'Kurdistan', 'code' => 'KRD']);
      $updatedData = ['name' => 'Kurdistan Updated', 'code' => 'KUR'];
      
      $updatedCountry = new Country($updatedData);
      
      $this->mock->shouldReceive('updateCountry')
        ->once()
        ->with(1, $updatedData)
        ->andReturn($updatedCountry);
      
      $result = $this->app->make(ICountryService::class)->updateCountry(1, $updatedData);
      
      $this->assertEquals('Kurdistan Updated', $result->name);
      $this->assertEquals('KUR', $result->code);
    }
    
    public function test_delete_country()
    {
      $this->mock->shouldReceive('deleteCountry')
        ->once()
        ->with(1)
        ->andReturn(true);
      
      $result = $this->app->make(ICountryService::class)->deleteCountry(1);
      
      $this->assertTrue($result);
    }
    
    public function test_get_country_by_id_throws_not_found_exception()
    {
      $this->mock->shouldReceive('getCountryById')
        ->once()
        ->with(999)
        ->andThrow(new NotFoundException("Country with ID 999 not found."));
      
      $this->expectException(NotFoundException::class);
      $this->app->make(ICountryService::class)->getCountryById(999);
    }
    
    public function test_update_country_throws_not_found_exception()
    {
      $this->mock->shouldReceive('updateCountry')
        ->once()
        ->with(999, Mockery::type('array'))
        ->andThrow(new NotFoundException("Country with ID 999 not found."));
      
      $this->expectException(NotFoundException::class);
      $this->app->make(ICountryService::class)->updateCountry(999, []);
    }
    
    public function test_delete_country_throws_not_found_exception()
    {
      $this->mock->shouldReceive('deleteCountry')
        ->once()
        ->with(999)
        ->andThrow(new NotFoundException("Country with ID 999 not found."));
      
      $this->expectException(NotFoundException::class);
      $this->app->make(ICountryService::class)->deleteCountry(999);
    }
  }
