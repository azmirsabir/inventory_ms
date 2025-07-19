<?php
  
  namespace App\Models;
  
  use App\Http\Filters\QueryFilter;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\HasMany;
  
  class Product extends Model
  {
    use HasFactory;
    
    protected $fillable = ['name', 'sku', 'status', 'description', 'price'];
    
    protected $table = 'products';
    
    public function scopeFilter($query, QueryFilter $filters)
    {
      return $filters->apply($query);
    }
    
    public function inventoryTransactions(): HasMany
    {
      return $this->hasMany(InventoryTransaction::class);
    }
  }
