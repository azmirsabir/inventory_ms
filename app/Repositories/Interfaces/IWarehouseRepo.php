<?php

namespace App\Repositories\Interfaces;

use App\Models\Warehouse;

interface IWarehouseRepo
{
  public function all($filters);
  public function find($id): ?Warehouse;
  public function create(array $data): Warehouse;
  public function update(Warehouse $warehouse, array $data) : Warehouse;
  public function delete(Warehouse $warehouse): bool;
}
