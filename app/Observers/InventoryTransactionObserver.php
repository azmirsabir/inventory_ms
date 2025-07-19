<?php

namespace App\Observers;

use App\Models\InventoryTransaction;

class InventoryTransactionObserver
{
    /**
     * Handle the InventoryTransaction "created" event.
     */
    public function created(InventoryTransaction $transaction): void
    {
    
    }

    /**
     * Handle the InventoryTransaction "updated" event.
     */
    public function updated(InventoryTransaction $transaction): void
    {
        //
    }

    /**
     * Handle the InventoryTransaction "deleted" event.
     */
    public function deleted(InventoryTransaction $transaction): void
    {
        //
    }

    /**
     * Handle the InventoryTransaction "force deleted" event.
     */
    public function forceDeleted(InventoryTransaction $transaction): void
    {
        //
    }
}
