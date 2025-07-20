<?php

namespace App\Services;

use App\Events\LowStockDetected;
use App\Exceptions\InsufficientStockException;
use App\Exceptions\NotFoundException;
use App\Models\InventoryTransaction;
use App\Repositories\Interfaces\IInventoryRepo;
use App\Repositories\Interfaces\IInventoryTransactionRepo;
use App\Services\Interface\IInventoryTransactionService;
use Illuminate\Support\Facades\DB;

class InventoryTransactionService implements IInventoryTransactionService
{
  protected IInventoryTransactionRepo $transactionRepository;
  protected IInventoryRepo $inventoryRepository;
  public function __construct(IInventoryTransactionRepo $transactionRepository,IInventoryRepo $inventoryRepository)
  {
    $this->transactionRepository = $transactionRepository;
    $this->inventoryRepository = $inventoryRepository;
  }
  public function getAllTransactions($filters)
  {
    return $this->transactionRepository->all($filters);
  }
  public function getTransactionById($id): InventoryTransaction
  {
    $transaction = $this->transactionRepository->find($id);
    if (!$transaction) {
      throw new NotFoundException("Transaction with ID {$id} not found.");
    }
    return $transaction;
  }
  //creates only single transaction
  public function createTransaction(array $data, bool $useTransaction = true): InventoryTransaction
  {
      $callback = function () use ($data) {
        $data['created_by'] = auth()->id();
        
        $productId = $data['product_id'];
        $warehouseId = $data['warehouse_id'];
        $quantity = $data['quantity'];
        $type = strtolower($data['transaction_type']);
        
        $inventory = $this->inventoryRepository->findInWarehouse($productId, $warehouseId);
        if ($type === 'out') {
          if (!$inventory) {
            throw new NotFoundException("Product ID {$productId} not found in warehouse ID {$warehouseId}.");
          }
          
          if (!$this->inventoryRepository->hasSufficientStock($inventory, $quantity)) {
            
            dispatch(function () {
              event(new LowStockDetected());
            })->afterResponse();
            
            throw new InsufficientStockException("Insufficient stock for product ID {$productId} in warehouse ID {$warehouseId}.");
          }
          
          $this->inventoryRepository->decrementStock($inventory, $quantity);
        }
        
        if ($type === 'in') {
          if ($inventory === null) {
            $this->inventoryRepository->create([
              'product_id' => $productId,
              'warehouse_id' => $warehouseId,
              'quantity' => $quantity
            ]);
          }else{
            $this->inventoryRepository->incrementStock($inventory, $quantity);
          }
        }
        
        $transaction = $this->transactionRepository->create($data);
        
        return $transaction;
      };
      return $useTransaction ? DB::transaction($callback) : $callback();
  }
  
}
