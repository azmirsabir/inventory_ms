<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Repositories\Interfaces\ISupplierRepo;

class SupplierRepository implements ISupplierRepo
{
    protected $model;
    public function __construct(Supplier $supplier)
    {
      $this->model = $supplier;
    }
    public function all($filters)
    {
      return $this->model->filter($filters);
    }
    public function find($id) : ?Supplier
    {
      return $this->model->find($id);
    }
    public function create(array $data): Supplier
    {
      return $this->model->create($data);
    }
    public function update(Supplier $supplier, array $data): Supplier
    {
      $supplier->fill($data);
      $supplier->save();
      return $supplier;
    }
    public function delete(Supplier $supplier): bool
    {
      return $supplier->delete();
    }
}
