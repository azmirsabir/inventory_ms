<?php
  
  namespace App\Models;
  
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\HasMany;
  
  class Supplier extends Model
  {
    use HasFactory;
    
    protected $fillable = ['name', 'contact_info', 'address'];
    
    protected $table = 'suppliers';
    protected $casts = [
      'contact_info' => 'array',
    ];
    
    public function scopeFilter($query, $filters)
    {
      return $filters->apply($query);
    }
    
    public function inventoryTransactions(): HasMany
    {
      return $this->hasMany(InventoryTransaction::class);
    }
  }
