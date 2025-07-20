<?php

namespace App\Services\Interface;

use App\Models\Product;

interface IProductService
{
  public function getAllProducts($filters);
  public function getProductById($id) : Product;
  public function createProduct(array $data) : Product;
  public function updateProduct($id, array $data) : Product;
  public function deleteProduct($id) : bool;
}
