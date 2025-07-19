<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\IProductRepo;

class ProductRepository implements IProductRepo
{
    protected $model;
    public function __construct(Product $product)
    {
      $this->model = $product;
    }
    public function all($filters)
    {
      return $this->model->filter($filters);
    }
    public function find($id) : ?Product
    {
      return $this->model->find($id);
    }
    public function create(array $data): Product
    {
      return $this->model->create($data);
    }
    public function update(Product $product, array $data): Product
    {
      $product->fill($data);
      $product->save();
      return $product;
    }
    public function delete(Product $product): bool
    {
      return $product->delete();
    }
}
