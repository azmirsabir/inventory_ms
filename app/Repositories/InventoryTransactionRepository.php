<?php

namespace App\Repositories;

use App\Models\InventoryTransaction;
use App\Repositories\Interfaces\IInventoryTransactionRepo;
use Illuminate\Support\Facades\Log;

class InventoryTransactionRepository implements IInventoryTransactionRepo
{
    protected $model;
    public function __construct(InventoryTransaction $transaction)
    {
      $this->model = $transaction;
    }
    public function all($filters)
    {
      return $this->model->filter($filters);
    }
    public function find($id) : ?InventoryTransaction
    {
      return $this->model->find($id);
    }
    public function create(array $data): InventoryTransaction
    {
      return $this->model->create($data);
    }
    public function update(InventoryTransaction $transaction, array $data): InventoryTransaction
    {
      $transaction->fill($data);
      $transaction->save();
      return $transaction;
    }
    public function delete(InventoryTransaction $transaction): bool
    {
      return $transaction->delete();
    }
}
