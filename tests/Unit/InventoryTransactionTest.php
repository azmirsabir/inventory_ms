<?php

namespace Tests\Unit;

use App\Exceptions\NotFoundException;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Repositories\Interfaces\IInventoryRepo;
use App\Repositories\Interfaces\IInventoryTransactionRepo;
use App\Services\InventoryTransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class InventoryTransactionTest extends TestCase
{
  use RefreshDatabase;
  protected IInventoryTransactionRepo $transactionRepo;
  protected IInventoryRepo $inventoryRepo;
  protected InventoryTransactionService $service;
  
  protected function setUp(): void
  {
    parent::setUp();
    
    // Create mock repositories
    $this->transactionRepo = Mockery::mock(IInventoryTransactionRepo::class);
    $this->inventoryRepo = Mockery::mock(IInventoryRepo::class);
    
    // Inject mocks into the service
    $this->service = new InventoryTransactionService(
      $this->transactionRepo,
      $this->inventoryRepo
    );
  }
  
  protected function tearDown(): void
  {
    Mockery::close();
    parent::tearDown();
  }
  
  public function test_it_returns_transaction_when_found()
  {
    $transactionId = 10;
    $transaction = Mockery::mock(InventoryTransaction::class);
    
    $this->transactionRepo->shouldReceive('find')
      ->once()
      ->with($transactionId)
      ->andReturn($transaction);
    
    $result = $this->service->getTransactionById($transactionId);
    
    $this->assertInstanceOf(InventoryTransaction::class, $result);
  }
  
  public function test_it_throws_not_found_exception_when_transaction_missing()
  {
    $transactionId = 999;
    
    $this->transactionRepo->shouldReceive('find')
      ->once()
      ->with($transactionId)
      ->andReturn(null);
    
    $this->expectException(NotFoundException::class);
    $this->expectExceptionMessage("Transaction with ID {$transactionId} not found.");
    
    $this->service->getTransactionById($transactionId);
  }
  
  public function test_create_out_transaction_with_sufficient_inventory()
  {
    $data = [
      'product_id' => 2,
      'warehouse_id' => 1,
      'quantity' => 5,
      'transaction_type' => 'OUT',
    ];
    
    Auth::shouldReceive('id')->andReturn(1);
    
    $inventory = Mockery::mock(Inventory::class);
    
    $this->inventoryRepo->shouldReceive('findInWarehouse')
      ->once()
      ->with(2, 1)
      ->andReturn($inventory);
    
    $this->inventoryRepo->shouldReceive('hasSufficientStock')
      ->once()
      ->with($inventory, 5)
      ->andReturn(true);
    
    $this->inventoryRepo->shouldReceive('decrementStock')
      ->once()
      ->with($inventory, 5);
    
    $transaction = Mockery::mock(InventoryTransaction::class);
    $this->transactionRepo->shouldReceive('create')
      ->once()
      ->with(Mockery::on(function ($input) {
        return $input['product_id'] === 2 &&
          $input['warehouse_id'] === 1 &&
          $input['quantity'] === 5 &&
          strtolower($input['transaction_type']) === 'out' &&
          $input['created_by'] === 1;
      }))
      ->andReturn($transaction);
    
    DB::shouldReceive('transaction')
      ->once()
      ->andReturnUsing(fn ($callback) => $callback());
    
    $result = $this->service->createTransaction($data);
    
    $this->assertInstanceOf(InventoryTransaction::class, $result);
  }
}
