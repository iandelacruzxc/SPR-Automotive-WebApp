<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('status')->nullable(false)->change(); // No default value
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Revert back to ENUM with original values
            $table->enum('status', ['pending', 'confirmed', 'completed', 'canceled'])->change();
        });
    }
};
