<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StressAssessment;
use Inertia\Inertia;

class StressAssessmentController extends Controller
{
    // Store the stress assessment data
    public function store(Request $request)
{
    $request->validate([
        'responses' => 'required|array|min:10|max:10',
    ]);

    $responses = $request->responses;

    // Reverse the scores for questions 4, 5, 7, and 8
    $responses[3] = 4 - $responses[3]; // Question 4
    $responses[4] = 4 - $responses[4]; // Question 5
    $responses[6] = 4 - $responses[6]; // Question 7
    $responses[7] = 4 - $responses[7]; // Question 8

    $totalScore = array_sum($responses);

    // Determine the stress level and impact
    $stressLevel = 'Low';  // Default value
    $impact = 'Not difficult at all';  // Default value

    if ($totalScore >= 14 && $totalScore <= 26) {
        $stressLevel = 'Moderate';
        $impact = 'Somewhat difficult';
    } elseif ($totalScore >= 27) {
        $stressLevel = 'High';
        $impact = 'Very difficult';
    }

    // Store the data in the database
    StressAssessment::create([
        'user_id' => auth()->id(),
        'responses' => json_encode($responses),
        'total_score' => $totalScore,
        'stress_level' => $stressLevel,  // Assign the calculated stress level
        'impact' => $impact,  // Include the impact field
    ]);


    // Redirect to the results page
    return redirect()->route('stress.results');
}


    // Show the results page after the assessment is stored
    public function results()
    {
        $userId = auth()->id();

        // Fetch the latest stress assessment for the user
        $latestAssessment = StressAssessment::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        // Fetch all past assessments for the user
        $pastAssessments = StressAssessment::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Pass the results to the StressResults page
        return Inertia::render('StressResults', [
            'latestAssessment' => $latestAssessment, // Latest result
            'pastAssessments' => $pastAssessments,   // All past assessments
        ]);
    }
}
