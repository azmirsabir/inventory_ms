<?php

namespace App\Http\Controllers;

use App\Http\Filters\InventoryTransactionFilter;
use App\Http\Requests\InventoryTransactionStoreRequest;
use App\Http\Resources\InventoryTransactionResource;
use App\Services\Interface\IInventoryTransactionService;

/**
 * @OA\Tag(
 *     name="Supplier",
 *     description="Transaction APIs"
 * )
 */
class InventoryTransactionController extends Controller
{
    protected $transactionService;
    public function __construct(IInventoryTransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
  
  /**
   * @OA\Get(
   *     path="/api/v1/inventory-transactions",
   *     summary="Get list of inventory transactions",
   *     tags={"Inventory Transaction"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Response(
   *         response=200,
   *         description="List of inventory transactions",
   *         @OA\JsonContent(type="array", @OA\Items(
   *             @OA\Property(property="id", type="integer", example=1),
   *             @OA\Property(property="product_id", type="integer", example=5),
   *             @OA\Property(property="warehouse_id", type="integer", example=2),
   *             @OA\Property(property="supplier_id", type="integer", example=3),
   *             @OA\Property(property="quantity", type="integer", example=50),
   *             @OA\Property(property="transaction_type", type="string", example="IN"),
   *             @OA\Property(property="date", type="string", format="date", example="2025-07-18"),
   *             @OA\Property(property="created_at", type="string", format="date-time"),
   *             @OA\Property(property="updated_at", type="string", format="date-time")
   *         ))
   *     )
   * )
   */
    public function index(InventoryTransactionFilter $filters)
    {
        $transactions = $this->transactionService->getAllTransactions($filters);
        if ($filters->isPaginated()) {
        return response()
          ->withPagination($transactions,InventoryTransactionResource::collection($transactions));
      }
        return InventoryTransactionResource::collection($transactions);
    }
  
  /**
   * @OA\Post(
   *     path="/api/v1/inventory-transactions",
   *     summary="Create a new inventory transaction",
   *     tags={"Inventory Transaction"},
   *     security={{"bearerAuth":{}}},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"product_id", "warehouse_id", "supplier_id", "quantity", "transaction_type", "date"},
   *             @OA\Property(property="product_id", type="integer", example=5),
   *             @OA\Property(property="warehouse_id", type="integer", example=2),
   *             @OA\Property(property="supplier_id", type="integer", example=3),
   *             @OA\Property(property="quantity", type="integer", example=100),
   *             @OA\Property(property="transaction_type", type="string", example="IN", enum={"IN"}),
   *             @OA\Property(property="date", type="string", format="date", example="2025-07-18")
   *         )
   *     ),
   *     @OA\Response(
   *         response=201,
   *         description="Inventory transaction created",
   *         @OA\JsonContent(
   *             @OA\Property(property="id", type="integer", example=12),
   *             @OA\Property(property="product_id", type="integer", example=5),
   *             @OA\Property(property="warehouse_id", type="integer", example=2),
   *             @OA\Property(property="supplier_id", type="integer", example=3),
   *             @OA\Property(property="quantity", type="integer", example=100),
   *             @OA\Property(property="transaction_type", type="string", example="IN"),
   *             @OA\Property(property="date", type="string", format="date", example="2025-07-18"),
   *             @OA\Property(property="created_at", type="string", format="date-time"),
   *             @OA\Property(property="updated_at", type="string", format="date-time")
   *         )
   *     )
   * )
   */
    public function store(InventoryTransactionStoreRequest $request)
    {
        return InventoryTransactionResource::make(
          $this->transactionService->createTransaction($request->validated())
        );
    }
  
  /**
   * @OA\Get(
   *     path="/api/v1/inventory-transactions/{id}",
   *     summary="Get an inventory transaction by ID",
   *     tags={"Inventory Transaction"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
   *     @OA\Response(
   *         response=200,
   *         description="Inventory transaction detail",
   *         @OA\JsonContent(
   *             @OA\Property(property="id", type="integer", example=12),
   *             @OA\Property(property="product_id", type="integer", example=5),
   *             @OA\Property(property="warehouse_id", type="integer", example=2),
   *             @OA\Property(property="supplier_id", type="integer", example=3),
   *             @OA\Property(property="quantity", type="integer", example=100),
   *             @OA\Property(property="transaction_type", type="string", example="IN"),
   *             @OA\Property(property="date", type="string", format="date", example="2025-07-18"),
   *             @OA\Property(property="created_at", type="string", format="date-time"),
   *             @OA\Property(property="updated_at", type="string", format="date-time")
   *         )
   *     )
   * )
   */
    public function show(string $id)
    {
        return InventoryTransactionResource::make($this->transactionService->getTransactionById($id));
    }
}
