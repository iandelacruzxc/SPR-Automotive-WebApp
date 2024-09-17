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
    Schema::create('system_info', function (Blueprint $table) {
      $table->id(); // Primary key, auto-incrementing ID
      $table->string('meta_field'); // Column for meta field name
      $table->text('meta_value'); // Column for meta value
      $table->timestamps(); // Created at and updated at timestamps
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('system_info');
  }
};
