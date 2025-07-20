<?php

namespace Tests\Unit;

use App\Exceptions\NotFoundException;
use App\Models\Product;
use App\Repositories\Interfaces\IProductRepo;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ProductTest extends TestCase
{
  use RefreshDatabase;
  protected $mock;
  protected ProductService $service;
  
  protected function setUp(): void
  {
    parent::setUp();
    
    $this->mock = Mockery::mock(IProductRepo::class);
    $this->service = new ProductService($this->mock);
  }
  
  protected function tearDown(): void
  {
    Mockery::close();
    parent::tearDown();
  }
  
  public function test_create_product()
  {
    $data = [
      'name' => 'Test Product',
      'sku' => 'TP001',
      'status' => 'active',
      'description' => 'Test Description',
      'price' => 99.99
    ];
    
    $product = new Product($data);
    
    $this->mock->shouldReceive('create')
      ->once()
      ->with($data)
      ->andReturn($product);
    
    $result = $this->service->createProduct($data);
    
    $this->assertInstanceOf(Product::class, $result);
    $this->assertEquals('TP001', $result->sku);
  }
  
  public function test_get_product_by_id()
  {
    $product = new Product([
      'name' => 'Test Product',
      'sku' => 'TP001',
      'status' => 'active',
      'price' => 50
    ]);
    
    $this->mock->shouldReceive('find')
      ->once()
      ->with(1)
      ->andReturn($product);
    
    $result = $this->service->getProductById(1);
    
    $this->assertInstanceOf(Product::class, $result);
    $this->assertEquals('TP001', $result->sku);
  }
  
  public function test_update_product()
  {
    $product = new Product([
      'name' => 'Old Product',
      'sku' => 'OLD123',
      'status' => 'inactive',
      'price' => 20
    ]);
    
    $updatedData = [
      'name' => 'Updated Product',
      'sku' => 'UPD123',
      'status' => 'active',
      'description' => 'Updated',
      'price' => 200
    ];
    
    $updatedProduct = new Product($updatedData);
    
    $this->mock->shouldReceive('find')
      ->once()
      ->with(1)
      ->andReturn($product);
    
    $this->mock->shouldReceive('update')
      ->once()
      ->with($product, $updatedData)
      ->andReturn($updatedProduct);
    
    $result = $this->service->updateProduct(1, $updatedData);
    
    $this->assertInstanceOf(Product::class, $result);
    $this->assertEquals('UPD123', $result->sku);
    $this->assertEquals(200, $result->price);
  }
  
  public function test_delete_product()
  {
    $product = new Product([
      'name' => 'To Be Deleted',
      'sku' => 'DEL001',
      'status' => 'inactive',
      'price' => 10
    ]);
    
    $this->mock->shouldReceive('find')
      ->once()
      ->with(1)
      ->andReturn($product);
    
    $this->mock->shouldReceive('delete')
      ->once()
      ->with($product)
      ->andReturn(true);
    
    $result = $this->service->deleteProduct(1);
    
    $this->assertTrue($result);
  }
  
  public function test_get_product_by_id_throws_not_found()
  {
    $this->mock->shouldReceive('find')
      ->once()
      ->with(999)
      ->andReturn(null);
    
    $this->expectException(NotFoundException::class);
    $this->service->getProductById(999);
  }
  
  public function test_update_product_throws_not_found()
  {
    $this->mock->shouldReceive('find')
      ->once()
      ->with(999)
      ->andReturn(null);
    
    $this->expectException(NotFoundException::class);
    $this->service->updateProduct(999, []);
  }
  
  public function test_delete_product_throws_not_found()
  {
    $this->mock->shouldReceive('find')
      ->once()
      ->with(999)
      ->andReturn(null);
    
    $this->expectException(NotFoundException::class);
    $this->service->deleteProduct(999);
  }
}
