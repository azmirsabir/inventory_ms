<?php

namespace App\Http\Controllers;

use App\Http\Filters\SupplierFilter;
use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Services\Interface\ISupplierService;


/**
 * @OA\Tag(
 *     name="Supplier",
 *     description="Supplier Management APIs"
 * )
 */
class SupplierController extends Controller
{
    protected $supplierService;
    public function __construct(ISupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }
  
  /**
   * @OA\Get(
   *     path="/api/v1/supplier",
   *     summary="List all suppliers",
   *     tags={"Supplier"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Response(
   *         response=200,
   *         description="List of suppliers",
   *         @OA\JsonContent(type="array", @OA\Items(
   *             @OA\Property(property="id", type="integer", example=1),
   *             @OA\Property(property="name", type="string", example="Acme Supplier"),
   *             @OA\Property(property="contact_info", type="object",
   *                 @OA\Property(property="email", type="string", example="acme@supplier.com"),
   *                 @OA\Property(property="phone", type="string", example="+9647700000000")
   *             ),
   *             @OA\Property(property="address", type="string", example="Main Street, Erbil"),
   *             @OA\Property(property="created_at", type="string", format="date-time"),
   *             @OA\Property(property="updated_at", type="string", format="date-time")
   *         ))
   *     )
   * )
   */
    public function index(SupplierFilter $filters)
    {
        return $this->supplierService->getAllSuppliers($filters);
    }
  
  /**
   * @OA\Post(
   *     path="/api/v1/supplier",
   *     summary="Create a new supplier",
   *     tags={"Supplier"},
   *     security={{"bearerAuth":{}}},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"name"},
   *             @OA\Property(property="name", type="string", example="Acme Supplier"),
   *             @OA\Property(property="contact_info", type="object",
   *                 @OA\Property(property="email", type="string", example="acme@supplier.com"),
   *                 @OA\Property(property="phone", type="string", example="+9647700000000")
   *             ),
   *             @OA\Property(property="address", type="string", example="Main Street, Erbil")
   *         )
   *     ),
   *     @OA\Response(response=201, description="Supplier created")
   * )
   */
    public function store(SupplierStoreRequest $request)
    {
        return $this->supplierService->createSupplier($request->validated());
    }
  
  /**
   * @OA\Get(
   *     path="/api/v1/supplier/{id}",
   *     summary="Get a specific supplier",
   *     tags={"Supplier"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
   *     @OA\Response(
   *         response=200,
   *         description="Supplier details",
   *         @OA\JsonContent(
   *             @OA\Property(property="id", type="integer", example=1),
   *             @OA\Property(property="name", type="string", example="Acme Supplier"),
   *             @OA\Property(property="contact_info", type="object",
   *                 @OA\Property(property="email", type="string", example="acme@supplier.com"),
   *                 @OA\Property(property="phone", type="string", example="+9647700000000")
   *             ),
   *             @OA\Property(property="address", type="string", example="Main Street, Erbil"),
   *             @OA\Property(property="created_at", type="string", format="date-time"),
   *             @OA\Property(property="updated_at", type="string", format="date-time")
   *         )
   *     )
   * )
   */
    public function show(string $id)
    {
        return $this->supplierService->getSupplierById($id);
    }
  
  /**
   * @OA\Put(
   *     path="/api/v1/supplier/{id}",
   *     summary="Update a supplier",
   *     tags={"Supplier"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"name"},
   *             @OA\Property(property="name", type="string", example="Updated Supplier"),
   *             @OA\Property(property="contact_info", type="object",
   *                 @OA\Property(property="email", type="string", example="updated@supplier.com"),
   *                 @OA\Property(property="phone", type="string", example="+9647700001111")
   *             ),
   *             @OA\Property(property="address", type="string", example="Updated Street, Erbil")
   *         )
   *     ),
   *     @OA\Response(response=200, description="Supplier updated")
   * )
   */
    public function update(SupplierUpdateRequest $request, string $id)
    {
        return $this->supplierService->updateSupplier($id, $request->validated());
    }
  
  /**
   * @OA\Delete(
   *     path="/api/v1/supplier/{id}",
   *     summary="Delete a supplier",
   *     tags={"Supplier"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
   *     @OA\Response(response=204, description="Deleted successfully")
   * )
   */
    public function destroy(string $id)
    {
        return $this->supplierService->deleteSupplier($id);
    }
}
