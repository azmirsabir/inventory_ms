<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\Interfaces\IProductRepo;
use App\Services\Interface\IProductService;

class ProductService implements IProductService
{
  protected $productRepository;
  public function __construct(IProductRepo $productRepository)
  {
    $this->productRepository = $productRepository;
  }
  
  public function getAllProducts($filters)
  {
    return $this->productRepository->all($filters);
  }
  
  public function getProductById($id): Product
  {
    $product = $this->productRepository->find($id);
    if (!$product) {
      throw new NotFoundException("product with ID {$id} not found.");
    }
    return $product;
  }
  
  public function createProduct(array $data): Product
  {
    return $this->productRepository->create($data);
  }
  
  public function updateProduct($id, array $data): Product
  {
    $product = $this->productRepository->find($id);
    if (!$product) {
      throw new NotFoundException("product with ID {$id} not found.");
    }
    return $this->productRepository->update($product, $data);
  }
  
  public function deleteProduct($id): bool
  {
    $product = $this->productRepository->find($id);
    
    if (!$product) {
      throw new NotFoundException("product with ID {$id} not found.");
    }
    
    return $this->productRepository->delete($product);
  }
}
