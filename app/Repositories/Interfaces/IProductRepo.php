<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;

interface IProductRepo
{
  public function all($filters);
  public function find($id): ?Product;
  public function create(array $data): Product;
  public function update(Product $product, array $data) : Product;
  public function delete(Product $product): bool;
}
