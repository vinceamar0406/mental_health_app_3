<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StressAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',         // Add user_id to fillable
        'responses',       // Responses should already be here
        'impact',          // Impact should already be here
        'total_score',     // Total score should already be here
        'stress_level',        // Severity should already be here
    ];

    // Define relationship to User model (optional if needed)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
