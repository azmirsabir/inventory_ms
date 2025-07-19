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
        Schema::create('inventory_transactions', function (Blueprint $table) {
          $table->id();
          $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
          $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('restrict');
          $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('restrict');
          $table->integer('quantity');
          $table->enum('transaction_type', ['IN', 'OUT']);
          $table->date('date');
          $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
