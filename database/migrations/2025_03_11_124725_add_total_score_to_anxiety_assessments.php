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
        Schema::table('anxiety_assessments', function (Blueprint $table) {
            $table->integer('total_score')->after('responses')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('anxiety_assessments', function (Blueprint $table) {
            $table->dropColumn('total_score');
        });
    }
};
