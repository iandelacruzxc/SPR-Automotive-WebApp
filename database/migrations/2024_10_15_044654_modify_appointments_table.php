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
        Schema::table('appointments', function (Blueprint $table) {
            // Remove the title and description columns
            $table->dropColumn(['title', 'description']);
            
            // Add a message column
            $table->text('message')->nullable(); // Use text type for message
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Add the title and description columns back if rolling back
            $table->string('title')->after('user_id'); // Adjust placement as needed
            $table->text('description')->nullable()->after('title'); // Adjust placement as needed
            
            // Drop the message column if rolling back
            $table->dropColumn('message');
        });
    }
};
