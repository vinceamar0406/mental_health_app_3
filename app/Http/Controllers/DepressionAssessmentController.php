<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepressionAssessment;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DepressionAssessmentController extends Controller
{
    // Store assessment results in the database
    public function store(Request $request)
    {
        $request->validate([
            'responses' => 'required|array|min:9',
            'impact' => 'required|string',
            'total_score' => 'required|integer',
            'severity' => 'required|string',
        ]);

        DepressionAssessment::create([
            'user_id' => Auth::id(),
            'responses' => json_encode($request->responses),
            'impact' => $request->impact,
            'total_score' => $request->total_score,
            'severity' => $request->severity,
        ]);

        // Redirect to the results page instead of returning JSON
        return redirect()->route('depression.results');
    }

    // Fetch past assessments for results page
    public function results()
{
    $assessments = DepressionAssessment::where('user_id', Auth::id())->latest()->get();
    $latestResult = $assessments->first();

    return Inertia::render('DepressionResults', [
        'latest_result' => $latestResult,
        'past_results' => $assessments->skip(1)->map(function ($assessment) {
            return [
                'total_score' => $assessment->total_score,
                'severity' => $assessment->severity,
                'impact' => $assessment->impact,
                'date' => $assessment->created_at->format('F j, Y'), // Format the date properly
            ];
        })->values(),
    ]);
}


}
