<?php
  
  namespace App\Models;
  
  use App\Http\Filters\QueryFilter;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Support\Facades\Auth;
  
  class Country extends Model
  {
    use HasFactory;
    
    protected $fillable = ['name', 'code'];
    
    protected $table = 'countries';
    
    public function scopeFilter($query, QueryFilter $filters)
    {
      return $filters->apply($query);
    }
    
    public function warehouses()
    {
      return $this->hasMany(Warehouse::class);
    }
  }
