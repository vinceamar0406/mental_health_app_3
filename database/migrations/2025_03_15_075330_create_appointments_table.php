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
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to user
        $table->foreignId('assessment_id')->constrained()->onDelete('cascade'); // Link to assessment
        $table->enum('status', ['none', 'pending', 'approved', 'completed'])->default('pending');
        $table->dateTime('appointment_date')->nullable(); // Date & time of appointment
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
