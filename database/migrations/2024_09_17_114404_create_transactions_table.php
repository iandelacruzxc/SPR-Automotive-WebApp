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
    Schema::create('transactions', function (Blueprint $table) {
      $table->id(); // Primary key, auto-incrementing ID
      $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key reference to users table
      $table->foreignId('mechanic_id')->nullable()->constrained('mechanics')->onDelete('set null'); // Foreign key reference to mechanic_list table, set null on delete
      $table->string('code')->unique(); // Column for transaction code, unique value
      $table->string('client_name'); // Column for client's name
      $table->string('contact'); // Column for client's contact number
      $table->string('email'); // Column for client's email address
      $table->text('address'); // Column for client's address
      $table->decimal('amount', 10, 2); // Column for transaction amount, with 2 decimal places
      $table->string('status'); // Column for transaction status
      $table->timestamps(); // Created at and updated at timestamps
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('transactions');
  }
};
