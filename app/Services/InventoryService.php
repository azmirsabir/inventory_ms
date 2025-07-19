<?php
  
  namespace App\Services;
  
  use App\Exceptions\NotFoundException;
  use App\Http\Filters\InventoryFilter;
  use App\Http\Resources\InventoryGlobalViewResource;
  use App\Http\Resources\InventoryResource;
  use App\Models\Inventory;
  use App\Repositories\Interfaces\IInventoryRepo;
  use App\Services\Interface\IInventoryService;
  use App\Services\Interface\IInventoryTransactionService;
  use Illuminate\Http\Request;
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
      $inventories = $this->inventoryRepository->all($filters);
      if ($filters->isPaginated()) {
        return response()->withPagination($inventories, InventoryResource::collection($inventories));
      }
      return InventoryResource::collection($inventories);
    }
    
    public function getInventoryById($id): InventoryResource
    {
      $inventory = $this->inventoryRepository->find($id);
      if (!$inventory) {
        throw new NotFoundException("Inventory with ID {$id} not found.");
      }
      return new InventoryResource($inventory);
    }
    
    public function createInventory(array $data): InventoryResource
    {
      $inventory = $this->inventoryRepository->create($data);
      return new InventoryResource($inventory);
    }
    
    public function updateInventory($id, array $data): InventoryResource
    {
      $inventory = $this->inventoryRepository->find($id);
      if (!$inventory) {
        throw new NotFoundException("Inventory with ID {$id} not found.");
      }
      return new InventoryResource($this->inventoryRepository->update($inventory, $data));
    }
    
    public function deleteInventory($id): bool
    {
      $inventory = $this->inventoryRepository->find($id);
      
      if (!$inventory) {
        throw new NotFoundException("Inventory with ID {$id} not found.");
      }
      
      return $this->inventoryRepository->delete($inventory);
    }
    
    public function inventoryTransfer(array $data)
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
      } catch (\Throwable $e) {
        DB::rollBack();
        throw $e;
      }
    }
    
    public function getGlobalInventoryView($filters)
    {
      $globalInventory = $this->inventoryRepository->getGlobalInventory($filters);
      return InventoryGlobalViewResource::collection($globalInventory);
    }
    
    public function lowStockInventory($filters = new InventoryFilter(new Request()))
    {
      $lowStockInventories = $this->inventoryRepository->lowStockInventory($filters);
      return $lowStockInventories;
    }
  }
