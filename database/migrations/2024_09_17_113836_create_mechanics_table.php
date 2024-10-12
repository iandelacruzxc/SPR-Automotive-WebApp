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
    Schema::create('mechanics', function (Blueprint $table) {
      $table->id(); // Primary key, auto-incrementing ID
      $table->string('firstname', 100); // Column for mechanic's first name
      $table->string('middlename', 100)->nullable(); // Column for mechanic's middle name, nullable
      $table->string('lastname', 100); // Column for mechanic's last name
      $table->string('position', 50);
      $table->decimal('rate', 10, 2);
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
    Schema::dropIfExists('mechanics');
  }
};
