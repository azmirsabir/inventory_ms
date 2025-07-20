<?php

namespace App\Repositories\Interfaces;

use App\Http\Filters\InventoryFilter;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Collection;

interface IInventoryRepo
{
  public function all(InventoryFilter $filters);
  public function find($id): ?Inventory;
  public function create(array $data): Inventory;
  public function update(Inventory $inventory, array $data) : Inventory;
  public function delete(Inventory $inventory): bool;
  public function incrementStock(Inventory $inventory, int $quantity): bool;
  public function decrementStock(Inventory $inventory, int $quantity): bool;
  public function hasSufficientStock(Inventory $inventory, int $quantity): bool;
  public function findInWarehouse(int $productId, int $warehouseId): ?Inventory;
  public function getGlobalInventory($filters): Collection;
  public function lowStockInventory(): Collection;
  
}
