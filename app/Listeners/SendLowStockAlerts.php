<?php

namespace App\Listeners;

use App\Events\LowStockDetected;
use App\Http\Filters\ReportFilter;
use App\Jobs\CheckLowStockJob;
use App\Mail\LowStockMail;
use App\Notifications\LowStockNotification;
use App\Services\Interface\IInventoryService;
use App\Services\Interface\INotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\App;

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
