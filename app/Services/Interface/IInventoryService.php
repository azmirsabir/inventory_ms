<?php

namespace App\Services\Interface;

use App\Models\Inventory;

interface IInventoryService
{
    public function getAllInventories($filters);
    public function getInventoryById($id) : Inventory;
    public function createInventory(array $data) : Inventory;
    public function updateInventory($id, array $data) : Inventory;
    public function deleteInventory($id) : bool;
    public function inventoryTransfer(array $data) : bool;
    public function getGlobalInventoryView($filters);
    public function lowStockInventory();
}
