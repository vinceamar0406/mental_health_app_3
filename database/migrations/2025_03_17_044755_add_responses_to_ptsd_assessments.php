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
        Schema::table('ptsd_assessments', function (Blueprint $table) {
            $table->json('responses')->nullable()->after('severity'); // Add the 'responses' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ptsd_assessments', function (Blueprint $table) {
            $table->dropColumn('responses'); // Rollback if needed
        });
    }
};
