<?php

namespace App\Providers;

use App\Http\Filters\InventoryFilter;
use App\Repositories\CountryRepository;
use App\Repositories\Interfaces\ICountryRepo;
use App\Repositories\Interfaces\IInventoryRepo;
use App\Repositories\Interfaces\IInventoryTransactionRepo;
use App\Repositories\Interfaces\IProductRepo;
use App\Repositories\Interfaces\ISupplierRepo;
use App\Repositories\Interfaces\IUserRepo;
use App\Repositories\Interfaces\IWarehouseRepo;
use App\Repositories\InventoryRepository;
use App\Repositories\InventoryTransactionRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SupplierRepository;
use App\Repositories\UserRepository;
use App\Repositories\WarehouseRepository;
use App\Services\AuthService;
use App\Services\CountryService;
use App\Services\Interface\IAuthService;
use App\Services\Interface\ICountryService;
use App\Services\Interface\IInventoryService;
use App\Services\Interface\IInventoryTransactionService;
use App\Services\Interface\INotificationService;
use App\Services\Interface\IProductService;
use App\Services\Interface\IReportService;
use App\Services\Interface\ISupplierService;
use App\Services\Interface\IWarehouseService;
use App\Services\InventoryService;
use App\Services\InventoryTransactionService;
use App\Services\NotificationService;
use App\Services\ProductService;
use App\Services\ReportService;
use App\Services\SupplierService;
use App\Services\WarehouseService;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      //repository binding
      $this->app->bind(ICountryRepo::class, CountryRepository::class);
      $this->app->bind(IInventoryRepo::class, InventoryRepository::class);
      $this->app->bind(IProductRepo::class, ProductRepository::class);
      $this->app->bind(ISupplierRepo::class, SupplierRepository::class);
      $this->app->bind(IWarehouseRepo::class, WarehouseRepository::class);
      $this->app->bind(IInventoryTransactionRepo::class, InventoryTransactionRepository::class);
      $this->app->bind(IUserRepo::class, UserRepository::class);
      
      //service binding
      $this->app->bind(ICountryService::class, CountryService::class);
      $this->app->bind(IInventoryService::class, InventoryService::class);
      $this->app->bind(IProductService::class, ProductService::class);
      $this->app->bind(ISupplierService::class, SupplierService::class);
      $this->app->bind(IWarehouseService::class, WarehouseService::class);
      $this->app->bind(IInventoryTransactionService::class, InventoryTransactionService::class);
      $this->app->bind(IReportService::class, ReportService::class);
      $this->app->bind(IAuthService::class, AuthService::class);
      $this->app->bind(INotificationService::class, NotificationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
