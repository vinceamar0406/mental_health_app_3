<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Move depression assessment records into mental_health_assessments
        DB::statement("
            INSERT INTO mental_health_assessments (user_id, assessment_type, responses, total_score, severity, impact, created_at, updated_at)
            SELECT user_id, 'depression' AS assessment_type, responses, total_score, severity, impact, created_at, updated_at
            FROM depression_assessments
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the depression records from mental_health_assessments
        DB::table('mental_health_assessments')->where('assessment_type', 'depression')->delete();
    }
};
