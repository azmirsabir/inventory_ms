<?php
  
  use App\Events\LowStockDetected;
  use App\Mail\LowStockMail;
  use App\Notifications\LowStockNotification;
  use App\Services\Interface\IInventoryService;
  use App\Services\Interface\INotificationService;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\App;
  use Illuminate\Support\Facades\Log;
  use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//  Log::info("Azmirrrr");
//    $inventoryService = App::make(IInventoryService::class);
//    $notificationService = App::make(INotificationService::class);
//    $data = $inventoryService->lowStockInventory();
//
//    $notificationService->sendSlackNotification($data, config('notification.slack.low_stock_channel_url'), LowStockNotification::class);
//    $notificationService->sendEmailNotification(config('notification.email.low_stock_report'), $data, LowStockMail::class);

//    event(new LowStockDetected());
    return view('welcome');
});
