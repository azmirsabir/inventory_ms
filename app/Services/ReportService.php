<?php

namespace App\Services;

use App\Repositories\Interfaces\IInventoryRepo;
use App\Services\Interface\IInventoryService;
use App\Services\Interface\IReportService;

class ReportService implements IReportService
{
    protected IInventoryService $inventoryService;
    /**
     * Create a new class instance.
     */
    public function __construct(IInventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }
    
    public function getLowStockReport()
    {
        return $this->inventoryService->lowStockInventory();
    }
}
