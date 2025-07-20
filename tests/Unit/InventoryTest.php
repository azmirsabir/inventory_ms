<?php
  
  namespace Tests\Unit;
  
  use App\Exceptions\NotFoundException;
  use App\Models\Inventory;
  use App\Repositories\Interfaces\IInventoryRepo;
  use App\Services\Interface\IInventoryTransactionService;
  use App\Services\InventoryService;
  use Illuminate\Foundation\Testing\RefreshDatabase;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\DB;
  use Mockery;
  use Tests\TestCase;
  
  class InventoryTest extends TestCase
  {
    use RefreshDatabase;
    
    protected $inventoryRepo;
    protected $transactionService;
    protected $inventoryService;
    
    protected function setUp(): void
    {
      parent::setUp();
      
      $this->inventoryRepo = Mockery::mock(IInventoryRepo::class);
      $this->transactionService = Mockery::mock(IInventoryTransactionService::class);
      
      $this->inventoryService = new InventoryService(
        $this->inventoryRepo,
        $this->transactionService
      );
      
      Auth::shouldReceive('id')->andReturn(1);
    }
    protected function tearDown(): void
    {
      Mockery::close();
      parent::tearDown();
    }
    
    public function test_inventory_transfer_successfully_creates_in_and_out_transactions()
    {
      $repoMock = Mockery::mock(IInventoryRepo::class);
      $transactionServiceMock = Mockery::mock(IInventoryTransactionService::class);
      
      $service = new InventoryService($repoMock, $transactionServiceMock);
      
      $data = [
        'product_id' => 2,
        'from_warehouse_id' => 1,
        'to_warehouse_id' => 2,
        'quantity' => 2,
        'date' => now(),
      ];
      
      Auth::shouldReceive('id')->andReturn(1);
      
      $transactionServiceMock
        ->shouldReceive('createTransaction')
        ->once()
        ->with(Mockery::on(function ($input) use ($data) {
          return $input['product_id'] === 2 &&
            $input['warehouse_id'] === 1 &&
            $input['quantity'] === 2 &&
            $input['transaction_type'] === 'OUT' &&
            $input['date'] === $data['date'] &&
            $input['created_by'] === 1;
        }), false);
      
      $transactionServiceMock
        ->shouldReceive('createTransaction')
        ->once()
        ->with(Mockery::on(function ($input) use ($data) {
          return $input['product_id'] === 2 &&
            $input['warehouse_id'] === 2 &&
            $input['quantity'] === 2 &&
            $input['transaction_type'] === 'IN' &&
            $input['date'] === $data['date'] &&
            $input['created_by'] === 1;
        }), false);
      
      $service->inventoryTransfer($data);
      
      $this->assertTrue(true);
    }
    
    public function test_inventory_transfer_rollback_on_exception()
    {
      $data = [
        'product_id' => 10,
        'from_warehouse_id' => 1,
        'to_warehouse_id' => 2,
        'quantity' => 5,
        'date' => '2025-07-19',
      ];
      
      DB::shouldReceive('beginTransaction')->once();
      DB::shouldReceive('commit')->never();
      DB::shouldReceive('rollBack')->once();
      
      $this->transactionService
        ->shouldReceive('createTransaction')
        ->once()
        ->andThrow(new \Exception("Transaction failed"));
      
      $this->expectException(\Exception::class);
      $this->expectExceptionMessage("Transaction failed");
      
      $this->inventoryService->inventoryTransfer($data);
    }
    
    public function test_get_inventory_by_id_success()
    {
      $inventory = new Inventory([
        'product_id' => 1,
        'warehouse_id' => 2,
        'minimum_quantity' => 10,
      ]);
      
      $this->inventoryRepo
        ->shouldReceive('find')
        ->once()
        ->with(1)
        ->andReturn($inventory);
      
      $result = $this->inventoryService->getInventoryById(1);
      
      $this->assertInstanceOf(Inventory::class, $result);
      $this->assertEquals(1, $result->product_id);
    }
    
    public function test_get_inventory_by_id_not_found()
    {
      $this->inventoryRepo
        ->shouldReceive('find')
        ->once()
        ->with(999)
        ->andReturn(null);
      
      $this->expectException(NotFoundException::class);
      $this->expectExceptionMessage("Inventory with ID 999 not found.");
      
      $this->inventoryService->getInventoryById(999);
    }
    
    public function test_create_inventory_success()
    {
      $data = [
        'product_id' => 1,
        'warehouse_id' => 2,
        'minimum_quantity' => 5,
      ];
      
      $inventory = new Inventory($data);
      
      $this->inventoryRepo
        ->shouldReceive('create')
        ->once()
        ->with($data)
        ->andReturn($inventory);
      
      $result = $this->inventoryService->createInventory($data);
      
      $this->assertInstanceOf(Inventory::class, $result);
      $this->assertEquals(5, $result->minimum_quantity);
    }
    
    public function test_update_inventory_success()
    {
      $existing = new Inventory([
        'product_id' => 1,
        'warehouse_id' => 2,
        'minimum_quantity' => 5,
      ]);
      
      $data = [
        'minimum_quantity' => 20,
      ];
      
      $updated = new Inventory([
        'product_id' => 1,
        'warehouse_id' => 2,
        'minimum_quantity' => 20,
      ]);
      
      $this->inventoryRepo
        ->shouldReceive('find')
        ->once()
        ->with(1)
        ->andReturn($existing);
      
      $this->inventoryRepo
        ->shouldReceive('update')
        ->once()
        ->with($existing, $data)
        ->andReturn($updated);
      
      $result = $this->inventoryService->updateInventory(1, $data);
      
      $this->assertEquals(20, $result->minimum_quantity);
    }
    
    public function test_update_inventory_not_found()
    {
      $this->inventoryRepo
        ->shouldReceive('find')
        ->once()
        ->with(999)
        ->andReturn(null);
      
      $this->expectException(NotFoundException::class);
      $this->expectExceptionMessage("Inventory with ID 999 not found.");
      
      $this->inventoryService->updateInventory(999, ['minimum_quantity' => 50]);
    }
    
    public function test_delete_inventory_success()
    {
      $inventory = new Inventory([
        'product_id' => 1,
        'warehouse_id' => 2,
        'minimum_quantity' => 15,
      ]);
      
      $this->inventoryRepo
        ->shouldReceive('find')
        ->once()
        ->with(1)
        ->andReturn($inventory);
      
      $this->inventoryRepo
        ->shouldReceive('delete')
        ->once()
        ->with($inventory)
        ->andReturn(true);
      
      $result = $this->inventoryService->deleteInventory(1);
      
      $this->assertTrue($result);
    }
    
    public function test_delete_inventory_not_found()
    {
      $this->inventoryRepo
        ->shouldReceive('find')
        ->once()
        ->with(999)
        ->andReturn(null);
      
      $this->expectException(NotFoundException::class);
      $this->expectExceptionMessage("Inventory with ID 999 not found.");
      
      $this->inventoryService->deleteInventory(999);
    }
  }
