<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Warehouse;
use App\Repositories\Interfaces\IWarehouseRepo;
use App\Services\Interface\IWarehouseService;

class WarehouseService implements IWarehouseService
{
  protected $warehouseRepository;
  public function __construct(IWarehouseRepo $warehouseRepository)
  {
    $this->warehouseRepository = $warehouseRepository;
  }
  
  public function getAllWarehouses($filters)
  {
    return $this->warehouseRepository->all($filters);
  }
  
  public function getWarehouseById($id): Warehouse
  {
    $warehouse = $this->warehouseRepository->find($id);
    if (!$warehouse) {
      throw new NotFoundException("Warehouse with ID {$id} not found.");
    }
    return $warehouse;
  }
  
  public function createWarehouse(array $data): Warehouse
  {
    return $this->warehouseRepository->create($data);
  }
  
  public function updateWarehouse($id, array $data): Warehouse
  {
    $warehouse = $this->warehouseRepository->find($id);
    if (!$warehouse) {
      throw new NotFoundException("Warehouse with ID {$id} not found.");
    }
    return $this->warehouseRepository->update($warehouse, $data);
  }
  
  public function deleteWarehouse($id): bool
  {
    $warehouse = $this->warehouseRepository->find($id);
    
    if (!$warehouse) {
      throw new NotFoundException("Warehouse with ID {$id} not found.");
    }
    
    return $this->warehouseRepository->delete($warehouse);
  }
}
