<?php

namespace App\Services\Interface;

use App\Http\Resources\SupplierResource;
use App\Models\Supplier;

interface ISupplierService
{
  public function getAllSuppliers($filters);
  public function getSupplierById($id) : Supplier;
  public function createSupplier(array $data) : Supplier;
  public function updateSupplier($id, array $data) : Supplier;
  public function deleteSupplier($id) : bool;
}
