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
    Schema::create('products', function (Blueprint $table) {
      $table->id(); // Primary key, auto-incrementing ID
      $table->string('name'); // Column for product name
      $table->text('description')->nullable(); // Column for product description, nullable
      $table->decimal('price', 10, 2); // Column for product price, with 2 decimal places
      $table->string('image_path')->nullable(); // Column for image path, nullable
      $table->boolean('status')->default(true); // Column for status, default to true
      $table->boolean('delete_flag')->default(false); // Column for delete flag, default to false
      $table->timestamps(); // Created at and updated at timestamps
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('products');
  }
};
