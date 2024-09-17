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
    Schema::create('transaction_services', function (Blueprint $table) {
      $table->id(); // Primary key, auto-incrementing ID
      $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Foreign key reference to service_list table
      $table->decimal('price', 10, 2); // Column for service price, with 2 decimal places
      $table->timestamps(); // Created at and updated at timestamps
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('transaction_services');
  }
};
