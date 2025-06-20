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
    Schema::create('services', function (Blueprint $table) {
      $table->id(); // Primary key, auto-incrementing ID
      $table->string('name'); // Column for service name
      $table->text('description')->nullable(); // Column for service description, nullable
      $table->decimal('price', 10, 2); // Column for service price, with 2 decimal places
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
    Schema::dropIfExists('services');
  }
};
