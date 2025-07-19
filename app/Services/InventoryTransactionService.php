<?php

namespace App\Services;

use App\Events\LowStockDetected;
use App\Exceptions\InsufficientStockException;
use App\Exceptions\NotFoundException;
use App\Http\Resources\InventoryTransactionResource;
use App\Repositories\Interfaces\IInventoryRepo;
use App\Repositories\Interfaces\IInventoryTransactionRepo;
use App\Services\Interface\IInventoryTransactionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
    $transactions = $this->transactionRepository->all($filters);
    if ($filters->isPaginated()) {
      return response()->withPagination($transactions,InventoryTransactionResource::collection($transactions));
    }
    return InventoryTransactionResource::collection($transactions);
  }
  public function getTransactionById($id): InventoryTransactionResource
  {
    $transaction = $this->transactionRepository->find($id);
    if (!$transaction) {
      throw new NotFoundException("Transaction with ID {$id} not found.");
    }
    return new InventoryTransactionResource($transaction);
  }
  //creates only single transaction
  public function createTransaction(array $data, bool $useTransaction = true): InventoryTransactionResource
  {
      $callback = function () use ($data) {
        $data['created_by'] = 1;
        
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
        
        return new InventoryTransactionResource($transaction);
      };
      return $useTransaction ? DB::transaction($callback) : $callback();
  }
  
}
