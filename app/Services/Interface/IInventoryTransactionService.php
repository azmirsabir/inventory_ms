<?php

namespace App\Services\Interface;

use App\Models\InventoryTransaction;

interface IInventoryTransactionService
{
    public function getAllTransactions($filters);
    public function getTransactionById($id) : InventoryTransaction;
    public function createTransaction(array $data) : InventoryTransaction;
}
