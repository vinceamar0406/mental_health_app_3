<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PTSDAssessment extends Model
{
    use HasFactory;

    // If your table is named "ptsd_assessments" (no underscores between each letter), set this:
    protected $table = 'ptsd_assessments';

    protected $fillable = [
        'user_id', 'responses', 'impact', 'total_score', 'severity',
    ];
}
