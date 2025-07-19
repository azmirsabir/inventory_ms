<?php

namespace App\Http\Controllers;

use App\Http\Filters\WarehouseFilter;
use App\Http\Requests\WarehouseStoreRequest;
use App\Http\Requests\WarehouseUpdateRequest;
use App\Services\Interface\IWarehouseService;

/**
 * @OA\Tag(
 *     name="Warehouse",
 *     description="Warehouse Management APIs"
 * )
 */
class WarehouseController extends Controller
{
    protected $warehouseService;
    public function __construct(IWarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }
  
  /**
   * @OA\Get(
   *     path="/api/v1/warehouse",
   *     summary="Get list of warehouses",
   *     tags={"Warehouse"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Response(
   *         response=200,
   *         description="List of warehouses",
   *         @OA\JsonContent(type="array", @OA\Items(
   *             @OA\Property(property="id", type="integer", example=1),
   *             @OA\Property(property="name", type="string", example="Main Warehouse"),
   *             @OA\Property(property="location", type="string", example="Erbil, Iraq"),
   *             @OA\Property(property="country_id", type="integer", example=2),
   *             @OA\Property(property="created_at", type="string", format="date-time"),
   *             @OA\Property(property="updated_at", type="string", format="date-time")
   *         ))
   *     )
   * )
   */
    public function index(WarehouseFilter $filters)
    {
        return $this->warehouseService->getAllWarehouses($filters);
    }
  
  /**
   * @OA\Post(
   *     path="/api/v1/warehouse",
   *     summary="Create a warehouse",
   *     tags={"Warehouse"},
   *     security={{"bearerAuth":{}}},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"name", "country_id"},
   *             @OA\Property(property="name", type="string", example="Main Warehouse"),
   *             @OA\Property(property="location", type="string", example="Kirkuk Road"),
   *             @OA\Property(property="country_id", type="integer", example=2)
   *         )
   *     ),
   *     @OA\Response(response=201, description="Warehouse created")
   * )
   */
    public function store(WarehouseStoreRequest $request)
    {
        return $this->warehouseService->createWarehouse($request->validated());
    }
  
  /**
   * @OA\Get(
   *     path="/api/v1/warehouse/{id}",
   *     summary="Get a single warehouse",
   *     tags={"Warehouse"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
   *     @OA\Response(
   *         response=200,
   *         description="Warehouse data",
   *         @OA\JsonContent(
   *             @OA\Property(property="id", type="integer", example=1),
   *             @OA\Property(property="name", type="string", example="Main Warehouse"),
   *             @OA\Property(property="location", type="string", example="Kirkuk Road"),
   *             @OA\Property(property="country_id", type="integer", example=2),
   *             @OA\Property(property="created_at", type="string", format="date-time"),
   *             @OA\Property(property="updated_at", type="string", format="date-time")
   *         )
   *     )
   * )
   */
    public function show(string $id)
    {
        return $this->warehouseService->getWarehouseById($id);
    }
  
  /**
   * @OA\Put(
   *     path="/api/v1/warehouse/{id}",
   *     summary="Update a warehouse",
   *     tags={"Warehouse"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"name", "country_id"},
   *             @OA\Property(property="name", type="string", example="Updated Warehouse"),
   *             @OA\Property(property="location", type="string", example="Sulaymaniyah Road"),
   *             @OA\Property(property="country_id", type="integer", example=2)
   *         )
   *     ),
   *     @OA\Response(response=200, description="Warehouse updated")
   * )
   */
    public function update(WarehouseUpdateRequest $request, string $id)
    {
        return $this->warehouseService->updateWarehouse($id, $request->validated());
    }
  
  /**
   * @OA\Delete(
   *     path="/api/v1/warehouse/{id}",
   *     summary="Delete a warehouse",
   *     tags={"Warehouse"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
   *     @OA\Response(response=204, description="Deleted successfully")
   * )
   */
    public function destroy(string $id)
    {
        return $this->warehouseService->deleteWarehouse($id);
    }
}
