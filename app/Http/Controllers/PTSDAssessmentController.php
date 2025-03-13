<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PTSDAssessment;

class PTSDAssessmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'total_score' => 'required|integer',
            'severity' => 'required|string',
            'impact' => 'required|string',
        ]);

        PTSDAssessment::create([
            'user_id' => auth()->id(),
            'total_score' => $request->total_score,
            'severity' => $request->severity,
            'impact' => $request->impact,
        ]);

        return redirect()->route('ptsd.results'); // or use Inertia for redirect: Inertia::location(route('ptsd.results'))
    }

    public function showPTSDResults()
    {
        $userId = auth()->id();

        // Fetch PTSD assessments for the user, ordered by latest first
        $assessments = PTSDAssessment::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('PTSDResults', [
            'results' => $assessments->first(), // Latest result
            'past_results' => $assessments->slice(1)->values(), // Past results
        ]);
    }
}
