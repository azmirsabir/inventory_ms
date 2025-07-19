<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Resources\SupplierResource;
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
    $suppliers = $this->supplierRepository->all($filters);
    if ($filters->isPaginated()) {
      return response()->withPagination($suppliers,SupplierResource::collection($suppliers));
    }
    return SupplierResource::collection($suppliers);
  }
  
  public function getSupplierById($id): SupplierResource
  {
    $supplier = $this->supplierRepository->find($id);
    if (!$supplier) {
      throw new NotFoundException("Supplier with ID {$id} not found.");
    }
    return new SupplierResource($supplier);
  }
  
  public function createSupplier(array $data): SupplierResource
  {
    return new SupplierResource($this->supplierRepository->create($data));
  }
  
  public function updateSupplier($id, array $data): SupplierResource
  {
    $supplier = $this->supplierRepository->find($id);
    if (!$supplier) {
      throw new NotFoundException("Supplier with ID {$id} not found.");
    }
    return new SupplierResource($this->supplierRepository->update($supplier, $data));
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
