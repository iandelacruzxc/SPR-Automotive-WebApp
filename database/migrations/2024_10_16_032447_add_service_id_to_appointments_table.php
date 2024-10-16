<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceIdToAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Add the service_id column
            $table->unsignedBigInteger('service_id')->nullable(); // or use appropriate type based on your service table
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Remove the service_id column
            $table->dropColumn('service_id');
        });
    }
}
