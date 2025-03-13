<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepressionAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Add this line
        'responses',
        'impact',
        'total_score',
        'severity'
    ];
}
