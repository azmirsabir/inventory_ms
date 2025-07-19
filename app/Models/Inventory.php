<?php
  
  namespace App\Models;
  
  use App\Http\Filters\QueryFilter;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  
  class Inventory extends Model
  {
    use HasFactory;
    
    protected $fillable = ['product_id', 'warehouse_id', 'quantity', 'minimum_quantity'];
    
    protected $table = 'inventories';
    
    public function product()
    {
      return $this->belongsTo(Product::class);
    }
    
    public function warehouse()
    {
      return $this->belongsTo(Warehouse::class);
    }
    
    public function scopeFilter($query, QueryFilter $filters)
    {
      return $filters->apply($query);
    }
    
    public function scopeSearch($query, $filters)
    {
      if ($warehouseId = $filters->get('warehouse_id')) {
        $query->where('warehouse_id', $warehouseId);
      }
      
      if ($productId = $filters->get('product_id')) {
        $query->where('product_id', $productId);
      }
      
      if ($countryId = $filters->get('country_id')) {
        $query->whereHas('warehouse', function ($q) use ($countryId) {
          $q->where('country_id', $countryId);
        });
      }
      
      return $query;
    }
  }
