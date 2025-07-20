<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Repositories\Interfaces\ISupplierRepo;
use App\Services\Interface\ISupplierService;

class SupplierService implements ISupplierService
{
  protected $supplierRepository;
  public function __construct(ISupplierRepo $supplierRepository)
  {
    $this->supplierRepository = $supplierRepository;
  }
  
  public function getAllSuppliers($filters)
  {
    return $this->supplierRepository->all($filters);
  }
  
  public function getSupplierById($id): Supplier
  {
    $supplier = $this->supplierRepository->find($id);
    if (!$supplier) {
      throw new NotFoundException("Supplier with ID {$id} not found.");
    }
    return $supplier;
  }
  
  public function createSupplier(array $data): Supplier
  {
    return $this->supplierRepository->create($data);
  }
  
  public function updateSupplier($id, array $data): Supplier
  {
    $supplier = $this->supplierRepository->find($id);
    if (!$supplier) {
      throw new NotFoundException("Supplier with ID {$id} not found.");
    }
    return $this->supplierRepository->update($supplier, $data);
  }
  
  public function deleteSupplier($id): bool
  {
    $supplier = $this->supplierRepository->find($id);
    
    if (!$supplier) {
      throw new NotFoundException("Supplier with ID {$id} not found.");
    }
    
    return $this->supplierRepository->delete($supplier);
  }
}
