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
    Schema::table('transactions', function (Blueprint $table) {
      $table->string('payment_status')->default('Unpaid')->nullable()->after('status'); // Add payment_status column with default
      $table->dateTime('estimated_completion_date')->nullable()->after('date_out'); // Add estimated_completion_date column
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('transactions', function (Blueprint $table) {
      $table->dropColumn('payment_status');
      $table->dropColumn('estimated_completion_date');
    });
  }
};
