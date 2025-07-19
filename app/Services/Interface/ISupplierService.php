<?php

namespace App\Services\Interface;

use App\Http\Resources\SupplierResource;

interface ISupplierService
{
  public function getAllSuppliers($filters);
  public function getSupplierById($id) : SupplierResource;
  public function createSupplier(array $data) : SupplierResource;
  public function updateSupplier($id, array $data) : SupplierResource;
  public function deleteSupplier($id) : bool;
}
