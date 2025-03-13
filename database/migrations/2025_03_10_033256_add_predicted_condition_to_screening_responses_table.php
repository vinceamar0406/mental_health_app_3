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
    Schema::table('screening_responses', function (Blueprint $table) {
        $table->string('predicted_condition')->nullable(); // Add nullable if it might not always be present
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('screening_responses', function (Blueprint $table) {
        $table->dropColumn('predicted_condition');
    });
}
};
