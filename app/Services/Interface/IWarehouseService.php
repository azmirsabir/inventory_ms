<?php

namespace App\Services\Interface;

use App\Models\Warehouse;

interface IWarehouseService
{
  public function getAllWarehouses($filters);
  public function getWarehouseById($id) : Warehouse;
  public function createWarehouse(array $data) : Warehouse;
  public function updateWarehouse($id, array $data) : Warehouse;
  public function deleteWarehouse($id) : bool;
}
