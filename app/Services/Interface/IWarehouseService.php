<?php

namespace App\Services\Interface;

use App\Http\Resources\WarehouseResource;

interface IWarehouseService
{
  public function getAllWarehouses($filters);
  public function getWarehouseById($id) : WarehouseResource;
  public function createWarehouse(array $data) : WarehouseResource;
  public function updateWarehouse($id, array $data) : WarehouseResource;
  public function deleteWarehouse($id) : bool;
}
