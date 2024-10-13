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
    Schema::create('transaction_products', function (Blueprint $table) {
      $table->id(); // Primary key, auto-incrementing ID
      $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
      $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Foreign key reference to product_list table
      $table->integer('quantity'); // Column for product quantity
      $table->decimal('price', 10, 2); // Column for product price, with 2 decimal places
      $table->timestamps(); // Created at and updated at timestamps
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('transaction_products');
  }
};
