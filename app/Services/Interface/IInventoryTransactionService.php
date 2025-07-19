<?php

namespace App\Services\Interface;

use App\Http\Resources\InventoryTransactionResource;

interface IInventoryTransactionService
{
    public function getAllTransactions($filters);
    public function getTransactionById($id) : InventoryTransactionResource;
    public function createTransaction(array $data) : InventoryTransactionResource;
}
