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
      $table->string('client_name', 100); // Column for client's name
      $table->string('unit', 100);
      $table->string('plate_no', 20);
      $table->string('color', 50);
      $table->text('address'); // Column for client's address
      $table->string('contact', 20); // Column for client's contact number
      $table->string('email', 50); // Column for client's email address
      $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key reference to users table
      $table->foreignId('mechanic_id')->nullable()->constrained('mechanics')->onDelete('set null'); // Foreign key reference to mechanic_list table, set null on delete
      $table->string('code', 50)->unique(); // Column for transaction code, unique value
      $table->decimal('downpayment', 10, 2)->nullable();
      $table->decimal('amount', 10, 2)->nullable(); // Column for transaction amount, with 2 decimal places
      $table->dateTime('date_in')->nullable();
      $table->dateTime('date_out')->nullable();
      $table->string('status', 50)->default('Pending'); // Column for transaction status
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
