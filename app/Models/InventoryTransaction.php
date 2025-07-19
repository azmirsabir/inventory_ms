<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'supplier_id',
        'quantity',
        'transaction_type', // 'in', 'out'
        'date',
        'created_by',
    ];

    protected $table = 'inventory_transactions';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
