<?php
  
  namespace App\Repositories;
  
  use App\Http\Filters\InventoryFilter;
  use App\Models\Inventory;
  use App\Repositories\Interfaces\IInventoryRepo;
  use Illuminate\Support\Facades\Cache;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Database\Eloquent\Collection;
  
  class InventoryRepository implements IInventoryRepo
  {
    /**
     * Create a new class instance.
     */
    protected $model;
    
    public function __construct(Inventory $inventory)
    {
      $this->model = $inventory;
    }
    
    public function all(InventoryFilter $filters)
    {
      return $this->model->filter($filters);
    }
    
    public function find($id): ?Inventory
    {
      $inventory=$this->model->find($id);
      $cacheKey = 'inventory_' . $id;
      
      return Cache::add($cacheKey, $inventory , now()->addHours(1)) ? Cache::get($cacheKey) : Cache::get($cacheKey);
    }
    
    public function create(array $data): Inventory
    {
      return $this->model->create($data);
    }
    
    public function update(Inventory $inventory, array $data): Inventory
    {
      $inventory->fill($data);
      $inventory->save();
      cache()->forget("inventory_$inventory->id");
      return $inventory;
    }
    
    public function delete(Inventory $inventory): bool
    {
      cache()->forget("inventory_$inventory->id");
      return $inventory->delete();
    }
    
    public function incrementStock(Inventory $inventory, int $quantity): bool
    {
      cache()->forget("inventory_$inventory->id");
      $inventory->quantity += $quantity;
      return $inventory->save();
    }
    
    public function decrementStock(Inventory $inventory, int $quantity): bool
    {
      cache()->forget("inventory_$inventory->id");
      $inventory->quantity -= $quantity;
      return $inventory->save();
    }
    
    public function hasSufficientStock(Inventory $inventory, int $quantity): bool
    {
      return $inventory && $inventory->quantity >= $quantity;
    }
    
    public function findInWarehouse(int $productId, int $warehouseId): ?Inventory
    {
      return Inventory::where('product_id', $productId)
        ->where('warehouse_id', $warehouseId)
        ->first();
    }
    
    public function getGlobalInventory($filters): Collection
    {
      return $this->model->search($filters)
        ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
        ->groupBy('product_id')
        ->get();
    }
    
    public function lowStockInventory(): Collection
    {
      return $this->model
        ->whereColumn('quantity', '<=', 'minimum_quantity')
        ->get();
    }
  }
