<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
          $table->id();
          $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
          $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('restrict');
          $table->integer('quantity')->default(0);
          $table->integer('minimum_quantity')->default(0);
          $table->timestamps();
          $table->softDeletes();
          
          $table->unique(['product_id', 'warehouse_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
