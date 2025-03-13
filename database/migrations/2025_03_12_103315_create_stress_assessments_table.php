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
        Schema::create('stress_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->json('responses'); // Store responses in JSON format
            $table->integer('total_score');
            $table->string('stress_level')->nullable(); // Make stress_level nullable
            $table->enum('impact', ['Not difficult at all', 'Somewhat difficult', 'Very difficult', 'Extremely difficult'])
                  ->nullable(); // Make the impact field nullable
            $table->timestamps();

            // Add foreign key constraint if necessary
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stress_assessments');
    }
};
