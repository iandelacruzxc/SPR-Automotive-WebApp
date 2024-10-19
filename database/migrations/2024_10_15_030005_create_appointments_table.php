<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->string('title'); // Title of the appointment
            $table->text('description')->nullable(); // Optional description
            $table->dateTime('appointment_date'); // Date and time of the appointment
            $table->enum('status', ['pending', 'confirmed', 'completed', 'canceled'])->default('pending'); // Appointment status
            $table->timestamps(); // Created at and updated at
            
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}

