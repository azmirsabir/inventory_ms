<?php

namespace App\Listeners;

use App\Events\LowStockDetected;
use App\Jobs\CheckLowStockJob;

class SendLowStockAlerts
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    
    }

    /**
     * Handle the event.
     */
    public function handle(LowStockDetected $event): void
    {
        CheckLowStockJob::dispatch();
    }
}
