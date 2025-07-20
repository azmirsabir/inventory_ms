<?php

namespace App\Jobs;

use App\Mail\LowStockMail;
use App\Notifications\LowStockNotification;
use App\Services\Interface\IInventoryService;
use App\Services\Interface\INotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class CheckLowStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Low stock check job started.');
      
        $inventoryService = App::make(IInventoryService::class);
        $notificationService = App::make(INotificationService::class);
      
        $lowStockProducts = $inventoryService->lowStockInventory();
        
        $notificationService->sendSlackNotification(
          $lowStockProducts,
          config('notification.slack.low_stock_channel_url'),
          LowStockNotification::class
        );
        
        $notificationService->sendEmailNotification(
          config('notification.email.low_stock_report'),
          $lowStockProducts,
          LowStockMail::class
        );
      
        Log::info('Low stock check job completed successfully.');
    }
}