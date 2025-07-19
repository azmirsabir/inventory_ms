<?php

namespace App\Repositories\Interfaces;

use App\Models\Supplier;

interface ISupplierRepo
{
  public function all($filters);
  public function find($id): ?Supplier;
  public function create(array $data): Supplier;
  public function update(Supplier $supplier, array $data) : Supplier;
  public function delete(Supplier $supplier): bool;
}
