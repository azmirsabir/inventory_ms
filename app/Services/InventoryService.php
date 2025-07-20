<?php
  
  namespace App\Services;
  
  use App\Exceptions\NotFoundException;
  use App\Models\Inventory;
  use App\Repositories\Interfaces\IInventoryRepo;
  use App\Services\Interface\IInventoryService;
  use App\Services\Interface\IInventoryTransactionService;
  use Illuminate\Support\Facades\DB;
  
  class InventoryService implements IInventoryService
  {
    /**
     * Create a new class instance.
     */
    protected IInventoryRepo $inventoryRepository;
    protected IInventoryTransactionService $transactionService;
    
    public function __construct(IInventoryRepo $inventoryRepository, IInventoryTransactionService $transactionService)
    {
      $this->inventoryRepository = $inventoryRepository;
      $this->transactionService = $transactionService;
    }
    
    public function getAllInventories($filters)
    {
      return $this->inventoryRepository->all($filters);
    }
    
    public function getInventoryById($id): Inventory
    {
      $inventory = $this->inventoryRepository->find($id);
      if (!$inventory) {
        throw new NotFoundException("Inventory with ID {$id} not found.");
      }
      return $inventory;
    }
    
    public function createInventory(array $data): Inventory
    {
      return $this->inventoryRepository->create($data);
    }
    
    public function updateInventory($id, array $data): Inventory
    {
      $inventory = $this->inventoryRepository->find($id);
      if (!$inventory) {
        throw new NotFoundException("Inventory with ID {$id} not found.");
      }
      return $this->inventoryRepository->update($inventory, $data);
    }
    
    public function deleteInventory($id): bool
    {
      $inventory = $this->inventoryRepository->find($id);
      
      if (!$inventory) {
        throw new NotFoundException("Inventory with ID {$id} not found.");
      }
      
      return $this->inventoryRepository->delete($inventory);
    }
    
    public function inventoryTransfer(array $data) :bool
    {
      DB::beginTransaction();
      try {
        $productId = $data['product_id'];
        $toWarehouseId = $data['to_warehouse_id'];
        $fromWarehouseId = $data['from_warehouse_id'];
        $quantity = $data['quantity'];
        $createdBy = auth()->id();
        $now = $data['date'];
        
        //record transactions
        $this->transactionService->createTransaction([
          'product_id' => $productId,
          'warehouse_id' => $fromWarehouseId,
          'quantity' => $quantity,
          'transaction_type' => 'OUT',
          'date' => $now,
          'created_by' => $createdBy,
        ], false);
        
        $this->transactionService->createTransaction([
          'product_id' => $productId,
          'warehouse_id' => $toWarehouseId,
          'quantity' => $quantity,
          'transaction_type' => 'IN',
          'date' => $now,
          'created_by' => $createdBy,
        ], false);
        
        DB::commit();
        return true;
      } catch (\Throwable $e) {
        DB::rollBack();
        throw $e;
      }
    }
    
    public function getGlobalInventoryView($filters)
    {
      return $this->inventoryRepository->getGlobalInventory($filters);
    }
    
    public function lowStockInventory()
    {
      return $this->inventoryRepository->lowStockInventory();
    }
  }
