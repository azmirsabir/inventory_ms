<?php

namespace App\Repositories\Interfaces;

use App\Models\InventoryTransaction;

interface IInventoryTransactionRepo
{
  public function all($filters);
  public function find($id): ?InventoryTransaction;
  public function create(array $data): InventoryTransaction;
  public function update(InventoryTransaction $transaction, array $data) : InventoryTransaction;
  public function delete(InventoryTransaction $transaction): bool;
}
