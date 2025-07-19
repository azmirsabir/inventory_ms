<?php

namespace App\Repositories;

use App\Models\Warehouse;
use App\Repositories\Interfaces\IWarehouseRepo;

class WarehouseRepository implements IWarehouseRepo
{
    protected $model;
    public function __construct(Warehouse $warehouse)
    {
      $this->model = $warehouse;
    }
    public function all($filters)
    {
      return $this->model->filter($filters);
    }
    public function find($id) : ?Warehouse
    {
      return $this->model->find($id);
    }
    public function create(array $data): Warehouse
    {
      return $this->model->create($data);
    }
    public function update(Warehouse $warehouse, array $data): Warehouse
    {
      $warehouse->fill($data);
      $warehouse->save();
      return $warehouse;
    }
    public function delete(Warehouse $warehouse): bool
    {
      return $warehouse->delete();
    }
}
