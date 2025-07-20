<?php

namespace App\Http\Controllers;

use App\Http\Filters\InventoryFilter;
use App\Http\Requests\InventoryStoreRequest;
use App\Http\Requests\InventoryTransferRequest;
use App\Http\Requests\InventoryUpdateRequest;
use App\Http\Resources\InventoryResource;
use App\Services\Interface\IInventoryService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Inventory",
 *     description="Inventory Management APIs"
 * )
 */
class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected IInventoryService $inventoryService;
    public function __construct(IInventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }
  
  /**
   * @OA\Get(
   *     path="/api/v1/inventory",
   *     tags={"Inventory"},
   *     summary="Get all inventory items",
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
   *     @OA\Response(response=200, description="Inventory list")
   * )
   */
    public function index(InventoryFilter $filters)
    {
      $inventories = $this->inventoryService->getAllInventories($filters);
      if ($filters->isPaginated()) {
        return response()->withPagination($inventories, InventoryResource::collection($inventories));
      }
      return InventoryResource::collection($filters);
    }
  
  /**
   * @OA\Post(
   *     path="/api/v1/inventory",
   *     tags={"Inventory"},
   *     summary="Create an inventory record",
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"product_id", "warehouse_id", "minimum_quantity"},
   *             @OA\Property(property="product_id", type="integer", example=1),
   *             @OA\Property(property="warehouse_id", type="integer", example=2),
   *             @OA\Property(property="minimum_quantity", type="integer", minimum=0, example=10)
   *         )
   *     ),
   *     @OA\Response(response=201, description="Inventory created")
   * )
   */
    public function store(InventoryStoreRequest $request)
    {
      return InventoryResource::make($this->inventoryService->createInventory($request->validated()));
    }
  
  /**
   * @OA\Get(
   *     path="/api/v1/inventory/{id}",
   *     tags={"Inventory"},
   *     summary="Get inventory by ID",
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
   *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
   *     @OA\Response(response=200, description="Inventory details"),
   *     @OA\Response(response=404, description="Inventory not found")
   * )
   */
    public function show($id)
    {
      return InventoryResource::make($this->inventoryService->getInventoryById($id));
    }
  
  /**
   * @OA\Put(
   *     path="/api/v1/inventory/{id}",
   *     tags={"Inventory"},
   *     summary="Update inventory record",
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
   *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             @OA\Property(property="product_id", type="integer", example=1),
   *             @OA\Property(property="warehouse_id", type="integer", example=2),
   *             @OA\Property(property="minimum_quantity", type="integer", minimum=0, example=10)
   *         )
   *     ),
   *     @OA\Response(response=200, description="Inventory updated"),
   *     @OA\Response(response=404, description="Inventory not found")
   * )
   */
    public function update(InventoryUpdateRequest $request, $id)
    {
      return InventoryResource::make($this->inventoryService->updateInventory($id, $request->validated()));
    }
  
  /**
   * @OA\Get(
   *     path="/api/v1/inventories/global-view",
   *     tags={"Inventory"},
   *     summary="Get global inventory view",
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
   *
   *     @OA\Parameter(
   *         name="warehouse_id",
   *         in="query",
   *         description="Filter by warehouse ID",
   *         required=false,
   *         @OA\Schema(type="integer", example=1)
   *     ),
   *
   *     @OA\Parameter(
   *         name="product_id",
   *         in="query",
   *         description="Filter by product ID",
   *         required=false,
   *         @OA\Schema(type="integer", example=2)
   *     ),
   *
   *     @OA\Response(response=200, description="Global inventory summary")
   * )
   */
    public function globalView(Request $filters){
      return InventoryResource::collection($this->inventoryService->getGlobalInventoryView($filters));
    }
  
  /**
   * @OA\Delete(
   *     path="/api/v1/inventory/{id}",
   *     tags={"Inventory"},
   *     summary="Delete inventory record",
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
   *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
   *     @OA\Response(response=204, description="Inventory deleted"),
   *     @OA\Response(response=404, description="Inventory not found")
   * )
   */
    public function destroy($id)
    {
      return $this->inventoryService->deleteInventory($id);
    }
  
  /**
   * @OA\Post(
   *     path="/api/v1/inventory-transfer",
   *     summary="Transfer inventory from one warehouse to another",
   *     tags={"Inventory Transaction"},
   *     security={{"bearerAuth":{}}},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"product_id", "from_warehouse_id", "to_warehouse_id", "quantity", "date"},
   *             @OA\Property(property="product_id", type="integer", example=7),
   *             @OA\Property(property="from_warehouse_id", type="integer", example=1),
   *             @OA\Property(property="to_warehouse_id", type="integer", example=2),
   *             @OA\Property(property="quantity", type="integer", example=50, minimum=1),
   *             @OA\Property(property="date", type="string", format="date", example="2025-07-18")
   *         )
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Inventory transfer completed",
   *     ),
   *     @OA\Response(
   *         response=422,
   *         description="Validation error"
   *     )
   * )
   */
    public function transfer(InventoryTransferRequest $request)
    {
      return $this->inventoryService->inventoryTransfer($request->validated());
    }
}
