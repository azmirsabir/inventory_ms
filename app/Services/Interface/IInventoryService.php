<?php

namespace App\Services\Interface;

use App\Http\Filters\InventoryFilter;
use App\Http\Resources\InventoryResource;
use Illuminate\Http\JsonResponse;

interface IInventoryService
{
    public function getAllInventories($filters);
    public function getInventoryById($id) : InventoryResource;
    public function createInventory(array $data) : InventoryResource;
    public function updateInventory($id, array $data) : InventoryResource;
    public function deleteInventory($id) : bool;
    public function inventoryTransfer(array $data);
    public function getGlobalInventoryView($filters);
    public function lowStockInventory($filters);
}
