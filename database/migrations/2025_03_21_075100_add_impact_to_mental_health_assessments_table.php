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
        Schema::table('mental_health_assessments', function (Blueprint $table) {
            $table->string('impact')->nullable(false); // Make sure it's required
        });
    }

    public function down()
    {
        Schema::table('mental_health_assessments', function (Blueprint $table) {
            $table->dropColumn('impact');
        });
    }

};
