<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Move PTSD assessments to the mental_health_assessments table
        DB::statement("
            INSERT INTO mental_health_assessments
            (user_id, assessment_type, responses, total_score, severity, impact, created_at, updated_at)
            SELECT
                user_id,
                'PTSD' AS assessment_type,
                COALESCE(responses, '[]') AS responses,
                total_score,
                severity,
                impact,
                created_at,
                updated_at
            FROM ptsd_assessments
        ");
    }

    public function down(): void
    {
        // Remove PTSD records from mental_health_assessments if we roll back
        DB::table('mental_health_assessments')->where('assessment_type', 'PTSD')->delete();
    }
};
