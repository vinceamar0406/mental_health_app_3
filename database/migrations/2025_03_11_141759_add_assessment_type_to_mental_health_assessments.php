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
        $table->string('assessment_type')->after('user_id'); // Add column after user_id
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mental_health_assessments', function (Blueprint $table) {
            $table->dropColumn('assessment_type'); // Allow rollback
        });
    }
};
