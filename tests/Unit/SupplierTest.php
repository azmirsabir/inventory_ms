<?php

namespace Tests\Unit;


use App\Exceptions\NotFoundException;
use App\Models\Supplier;
use App\Services\Interface\ISupplierService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class SupplierTest extends TestCase
{
  use RefreshDatabase;
  protected $mock;
  protected $supplier;
  
  protected function setUp(): void
  {
    parent::setUp();
    
    // Create a mock of ISupplierService
    $this->mock = Mockery::mock(ISupplierService::class);
    $this->app->instance(ISupplierService::class, $this->mock);
    
    //for testing return value
    $this->supplier = new Supplier([
      'name' => 'Test Supplier',
      'contact_info' => ['email' => 'supplier@example.com', 'phone' => '123456789'],
      'address' => 'Ranya'
    ]);
  }
  
  public function tearDown(): void
  {
    Mockery::close();
    parent::tearDown();
  }
  
  public function test_create_supplier()
  {
    $data = [
      'name' => 'Test Supplier',
      'contact_info' => ['email' => 'supplier@example.com', 'phone' => '123456789'],
      'address' => 'Ranya'
    ];
    
    $this->mock->shouldReceive('createSupplier')
      ->once()
      ->with($data)
      ->andReturn($this->supplier);
    
    $service = $this->app->make(ISupplierService::class);
    $result = $service->createSupplier($data);
    
    $this->assertEquals('Test Supplier', $result->name);
  }
  
  public function test_get_supplier_by_id()
  {
    $this->mock->shouldReceive('getSupplierById')
      ->once()
      ->with(1)
      ->andReturn($this->supplier);
    
    $service = $this->app->make(ISupplierService::class);
    $result = $service->getSupplierById(1);
    
    $this->assertEquals('Test Supplier', $result->name);
  }
  
  public function test_update_supplier()
  {
    $updateData = [
      'name' => 'Updated Supplier',
      'contact_info' => ['email' => 'updated@example.com'],
      'address' => 'Updated Address'
    ];
    
    $updatedSupplier = new Supplier($updateData);
    
    $this->mock->shouldReceive('updateSupplier')
      ->once()
      ->with(1, $updateData)
      ->andReturn($updatedSupplier);
    
    $service = $this->app->make(ISupplierService::class);
    $result = $service->updateSupplier(1, $updateData);
    
    $this->assertEquals('Updated Supplier', $result->name);
  }
  
  public function test_delete_supplier()
  {
    $this->mock->shouldReceive('deleteSupplier')
      ->once()
      ->with(1)
      ->andReturn(true);
    
    $service = $this->app->make(ISupplierService::class);
    $result = $service->deleteSupplier(1);
    
    $this->assertTrue($result);
  }
  
  public function test_get_supplier_by_id_not_found()
  {
    $this->mock->shouldReceive('getSupplierById')
      ->once()
      ->with(999)
      ->andThrow(new NotFoundException("Supplier with ID 999 not found."));
    
    $this->expectException(NotFoundException::class);
    
    $service = $this->app->make(ISupplierService::class);
    $service->getSupplierById(999);
  }
}