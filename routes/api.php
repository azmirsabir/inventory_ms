<?php
  
  use App\Http\Controllers\AuthController;
  use App\Http\Controllers\CountryController;
  use App\Http\Controllers\InventoryController;
  use App\Http\Controllers\InventoryTransactionController;
  use App\Http\Controllers\ProductController;
  use App\Http\Controllers\ReportController;
  use App\Http\Controllers\SupplierController;
  use App\Http\Controllers\WarehouseController;
  use Illuminate\Support\Facades\Route;
  
  
  Route::prefix('v1')->middleware('log')->group(function () {
  //auth routes
    Route::prefix('auth')->group(function () {
      Route::post('/register', [AuthController::class, 'register']);
      Route::post('/login', [AuthController::class, 'login']);
      
      Route::middleware('jwt')->group(function () {
        Route::get('/user', [AuthController::class, 'getUser']);
        Route::put('/user', [AuthController::class, 'updateUser']);
        Route::post('/logout', [AuthController::class, 'logout']);
      });
  });
  
  //resource routes
  Route::middleware(['jwt','role:admin'])->group(function () {
    Route::apiResource('country', CountryController::class);
    Route::apiResource('warehouse', WarehouseController::class);
    Route::apiResource('product', ProductController::class);
    Route::apiResource('inventory', InventoryController::class);
    Route::apiResource('supplier', SupplierController::class);
    Route::apiResource('inventory-transactions', InventoryTransactionController::class);
    
    Route::get('inventories/global-view', [InventoryController::class, 'globalView']);
    Route::post('inventory-transfer', [InventoryController::class, 'transfer']);
    Route::get('reports/low-stock', [ReportController::class, 'lowStockReport']);
  });
});
