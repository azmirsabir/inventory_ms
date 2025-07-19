<?php
  
  namespace App\Models;
  
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\HasMany;
  
  class Warehouse extends Model
  {
    use HasFactory;
    
    protected $fillable = ['name', 'location', 'country_id'];
    
    protected $table = 'warehouses';
    
    public function scopeFilter($query, $filters)
    {
      return $filters->apply($query);
    }
    
    public function country()
    {
      return $this->belongsTo(Country::class);
    }
    
    public function inventoryTransactions(): HasMany
    {
      return $this->hasMany(InventoryTransaction::class);
    }
  }
