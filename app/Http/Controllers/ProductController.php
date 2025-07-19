<?php

namespace App\Http\Controllers;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Services\Interface\IProductService;

/**
 * @OA\Tag(
 *     name="Product",
 *     description="Product management APIs"
 * )
 */
class ProductController extends Controller
{
    protected $productService;
    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }
  
  /**
   * @OA\Get(
   *     path="/api/v1/product",
   *     summary="Get all products",
   *     tags={"Product"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
   *     @OA\Response(response=200, description="List of products"),
   * )
   */
    public function index(ProductFilter $filters)
    {
        return $this->productService->getAllProducts($filters);
    }
  
  /**
   * @OA\Post(
   *     path="/api/v1/product",
   *     summary="Create a new product",
   *     tags={"Product"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
   *     @OA\RequestBody(
   *         required=true,
   *         description="Product data",
   *         @OA\JsonContent(
   *             required={"name", "sku", "status", "price"},
   *             @OA\Property(property="name", type="string", example="iPhone 15"),
   *             @OA\Property(property="sku", type="string", example="IP15-BLK-256"),
   *             @OA\Property(property="status", type="string", enum={"active", "inactive"}, example="active"),
   *             @OA\Property(property="description", type="string", example="Latest Apple iPhone"),
   *             @OA\Property(property="price", type="number", format="float", example=999.99)
   *         )
   *     ),
   *     @OA\Response(response=201, description="Product created successfully"),
   *     @OA\Response(response=422, description="Validation error")
   * )
   */
    public function store(ProductStoreRequest $request)
    {
        return $this->productService->createProduct($request->validated());
    }
  
  /**
   * @OA\Get(
   *     path="/api/v1/product/{id}",
   *     summary="Get a single product by ID",
   *     tags={"Product"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         @OA\Schema(type="string")
   *     ),
   *     @OA\Response(response=200, description="Product details"),
   *     @OA\Response(response=404, description="Product not found")
   * )
   */
    public function show(string $id)
    {
        return $this->productService->getProductById($id);
    }
  
  /**
   * @OA\Put(
   *     path="/api/v1/product/{id}",
   *     summary="Update an existing product",
   *     tags={"Product"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         @OA\Schema(type="string")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         description="Updated product data",
   *         @OA\JsonContent(
   *             @OA\Property(property="name", type="string", example="iPhone 15 Pro"),
   *             @OA\Property(property="sku", type="string", example="IP15PRO-BLK-512"),
   *             @OA\Property(property="status", type="string", enum={"active", "inactive"}, example="active"),
   *             @OA\Property(property="description", type="string", example="Updated description"),
   *             @OA\Property(property="price", type="number", format="float", example=1299.99)
   *         )
   *     ),
   *     @OA\Response(response=200, description="Product updated successfully"),
   *     @OA\Response(response=404, description="Product not found"),
   *     @OA\Response(response=422, description="Validation error")
   * )
   */
    public function update(ProductUpdateRequest $request, string $id)
    {
        return $this->productService->updateProduct($id, $request->validated());
    }
  
  /**
   * @OA\Delete(
   *     path="/api/v1/product/{id}",
   *     summary="Delete a product",
   *     tags={"Product"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         @OA\Schema(type="string")
   *     ),
   *     @OA\Response(response=204, description="Product deleted"),
   *     @OA\Response(response=404, description="Product not found")
   * )
   */
    public function destroy(string $id)
    {
        return $this->productService->deleteProduct($id);
    }
}
