<?php

namespace App\Http\Controllers;

use App\Services\Interface\IReportService;

/**
 * @OA\Tag(
 *     name="Report",
 *     description="Report Management APIs"
 * )
 */
class ReportController extends Controller
{
    protected IReportService $reportService;
    public function __construct(IReportService $reportService)
    {
        $this->reportService = $reportService;
    }
  
  /**
   * @OA\Get(
   *     path="/api/v1/report/low-stock",
   *     summary="Get report of products with low stock",
   *     tags={"Report"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
   *     @OA\Response(
   *         response=200,
   *         description="List of low stock products",
   *         @OA\JsonContent(
   *             type="array",
   *             @OA\Items(
   *                 @OA\Property(property="id", type="integer", example=1),
   *                 @OA\Property(property="product_id", type="integer", example=1),
   *                 @OA\Property(property="warehouse_id", type="integer", example=1),
   *                 @OA\Property(property="quantity", type="integer", example=100),
   *                 @OA\Property(property="minimum_quantity", type="integer", example=102),
   *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-14T22:12:50.000000Z"),
   *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-16T17:59:58.000000Z"),
   *                 @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, example=null)
   *             )
   *         )
   *     ),
   *     @OA\Response(response=401, description="Unauthenticated"),
   *     @OA\Response(response=403, description="Forbidden")
   * )
   */
    public function lowStockReport()
    {
      return $this->reportService->getLowStockReport();
    }
}
