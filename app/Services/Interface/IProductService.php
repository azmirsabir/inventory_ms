<?php

namespace App\Services\Interface;

use App\Http\Resources\ProductResource;

interface IProductService
{
  public function getAllProducts($filters);
  public function getProductById($id) : ProductResource;
  public function createProduct(array $data) : ProductResource;
  public function updateProduct($id, array $data) : ProductResource;
  public function deleteProduct($id) : bool;
}
