<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Resources\WarehouseResource;
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
    $warehouses = $this->warehouseRepository->all($filters);
    if ($filters->isPaginated()) {
      return response()->withPagination($warehouses,WarehouseResource::collection($warehouses));
    }
    return WarehouseResource::collection($warehouses);
  }
  
  public function getWarehouseById($id): WarehouseResource
  {
    $warehouse = $this->warehouseRepository->find($id);
    if (!$warehouse) {
      throw new NotFoundException("Warehouse with ID {$id} not found.");
    }
    return new WarehouseResource($warehouse);
  }
  
  public function createWarehouse(array $data): WarehouseResource
  {
    return new WarehouseResource($this->warehouseRepository->create($data));
  }
  
  public function updateWarehouse($id, array $data): WarehouseResource
  {
    $warehouse = $this->warehouseRepository->find($id);
    if (!$warehouse) {
      throw new NotFoundException("Warehouse with ID {$id} not found.");
    }
    return new WarehouseResource($this->warehouseRepository->update($warehouse, $data));
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
