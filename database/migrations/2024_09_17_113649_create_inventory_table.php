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
    Schema::create('inventory', function (Blueprint $table) {
      $table->id(); // Primary key, auto-incrementing ID
      $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Foreign key reference to product_list table
      $table->integer('quantity'); // Column for product quantity
      $table->date('stock_date'); // Column for stock date
      $table->timestamps(); // Created at and updated at timestamps
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('inventory');
  }
};
