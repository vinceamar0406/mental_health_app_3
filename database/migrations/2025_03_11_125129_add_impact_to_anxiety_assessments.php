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
        Schema::table('anxiety_assessments', function (Blueprint $table) {
            $table->string('impact')->after('total_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anxiety_assessments', function (Blueprint $table) {
            $table->dropColumn('impact');
        });
    }
};
