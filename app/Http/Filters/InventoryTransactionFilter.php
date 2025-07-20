<?php
  
  namespace App\Http\Filters;
  
  class InventoryTransactionFilter extends QueryFilter
  {
    
    public function include($value)
    {
      $relations = array_map('trim', explode(',', $value));
      
      return $this->builder->with($relations);
    }
    
    public function id($value)
    {
      return $this->builder->whereIn('id', explode(',', $value));
    }
    
    public function product($value)
    {
      return $this->builder->whereIn('product_id', explode(',', $value));
    }
    
    public function warehouse($value)
    {
      return $this->builder->whereIn('warehouse_id', explode(',', $value));
    }
    
    public function transaction_type($value)
    {
      return $this->builder->whereIn('transaction_type', explode(',', $value));
    }
    
    public function created_at($value)
    {
      $dates = explode(',', $value);
      
      if (count($dates) > 1) {
        return $this->builder->whereBetween('created_at', $dates);
      }
      
      return $this->builder->whereDate('created_at', $value);
    }
    
    public function perPage($value)
    {
      $this->perPage = (int)$value;
      return $this;
    }
    
    public function page($value)
    {
      $this->page = (int)$value;
      return $this;
    }
    
    public function pagination($value)
    {
      $this->paginate = filter_var($value, FILTER_VALIDATE_BOOLEAN);
      return $this;
    }
    
    public function isPaginated()
    {
      return $this->paginate;
    }
  }