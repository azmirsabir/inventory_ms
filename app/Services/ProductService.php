<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Resources\ProductResource;
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
    $products = $this->productRepository->all($filters);
    if ($filters->isPaginated()) {
      return response()->withPagination($products,ProductResource::collection($products));
    }
    return ProductResource::collection($products);
  }
  
  public function getProductById($id): ProductResource
  {
    $product = $this->productRepository->find($id);
    if (!$product) {
      throw new NotFoundException("product with ID {$id} not found.");
    }
    return new ProductResource($product);
  }
  
  public function createProduct(array $data): ProductResource
  {
    return new ProductResource($this->productRepository->create($data));
  }
  
  public function updateProduct($id, array $data): ProductResource
  {
    $product = $this->productRepository->find($id);
    if (!$product) {
      throw new NotFoundException("product with ID {$id} not found.");
    }
    return new ProductResource($this->productRepository->update($product, $data));
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
