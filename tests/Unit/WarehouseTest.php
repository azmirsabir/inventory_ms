<?php

namespace Tests\Unit;

use App\Exceptions\NotFoundException;
use App\Models\Warehouse;
use App\Services\Interface\IWarehouseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class WarehouseTest extends TestCase
{
  use refreshDatabase;
  protected $mock;
  protected $warehouse;
  
  protected function setUp(): void
  {
    parent::setUp();
    
    // Mock the IWarehouseService
    $this->mock = Mockery::mock(IWarehouseService::class);
    $this->app->instance(IWarehouseService::class, $this->mock);
    
    // Example warehouse model for return
    $this->warehouse = new Warehouse([
      'name' => 'Main Warehouse',
      'location' => 'Erbil',
      'country_id' => 1,
    ]);
  }
  
  protected function tearDown(): void
  {
    Mockery::close();
    parent::tearDown();
  }
  
  public function test_create_warehouse()
  {
    $data = [
      'name' => 'Main Warehouse',
      'location' => 'Erbil',
      'country_id' => 1,
    ];
    
    $this->mock->shouldReceive('createWarehouse')
      ->once()
      ->with($data)
      ->andReturn($this->warehouse);
    
    $service = $this->app->make(IWarehouseService::class);
    $result = $service->createWarehouse($data);
    
    $this->assertInstanceOf(Warehouse::class, $result);
    $this->assertEquals('Main Warehouse', $result->name);
    $this->assertEquals('Erbil', $result->location);
  }
  
  public function test_get_warehouse_by_id()
  {
    $this->mock->shouldReceive('getWarehouseById')
      ->once()
      ->with(1)
      ->andReturn($this->warehouse);
    
    $service = $this->app->make(IWarehouseService::class);
    $result = $service->getWarehouseById(1);
    
    $this->assertEquals('Main Warehouse', $result->name);
  }
  
  public function test_update_warehouse()
  {
    $updateData = [
      'name' => 'Updated Warehouse',
      'location' => 'Sulaimani',
      'country_id' => 1,
    ];
    
    $updatedWarehouse = new Warehouse($updateData);
    
    $this->mock->shouldReceive('updateWarehouse')
      ->once()
      ->with(1, $updateData)
      ->andReturn($updatedWarehouse);
    
    $service = $this->app->make(IWarehouseService::class);
    $result = $service->updateWarehouse(1, $updateData);
    
    $this->assertEquals('Updated Warehouse', $result->name);
    $this->assertEquals('Sulaimani', $result->location);
  }
  
  public function test_delete_warehouse()
  {
    $this->mock->shouldReceive('deleteWarehouse')
      ->once()
      ->with(1)
      ->andReturn(true);
    
    $service = $this->app->make(IWarehouseService::class);
    $result = $service->deleteWarehouse(1);
    
    $this->assertTrue($result);
  }
  
  public function test_get_warehouse_by_id_not_found()
  {
    $this->mock->shouldReceive('getWarehouseById')
      ->once()
      ->with(999)
      ->andThrow(new NotFoundException("Warehouse with ID 999 not found."));
    
    $this->expectException(NotFoundException::class);
    
    $service = $this->app->make(IWarehouseService::class);
    $service->getWarehouseById(999);
  }
  
  public function test_update_warehouse_not_found()
  {
    $data = [
      'name' => 'Ghost Warehouse',
      'location' => 'Unknown',
      'country_id' => 2,
    ];
    
    $this->mock->shouldReceive('updateWarehouse')
      ->once()
      ->with(999, $data)
      ->andThrow(new NotFoundException("Warehouse with ID 999 not found."));
    
    $this->expectException(NotFoundException::class);
    
    $service = $this->app->make(IWarehouseService::class);
    $service->updateWarehouse(999, $data);
  }
}