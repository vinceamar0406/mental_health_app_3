<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\MentalHealthAssessment;

class AssessmentController extends Controller
{
    public function index()
    {
        return Inertia::render('AssessmentHub');
    }

    // ✅ Assessment Hub - Displays available severity assessment options
    public function hub()
    {
        return Inertia::render('AssessmentHub', [
            'assessments' => [
                ['name' => 'Anxiety Assessment', 'route' => 'anxiety_assessment'],
                ['name' => 'Depression Assessment', 'route' => 'depression_assessment'],
                ['name' => 'PTSD Assessment', 'route' => 'ptsd_assessment'],
                ['name' => 'Stress-Related Disorder Assessment', 'route' => 'stress_assessment'],
                ['name' => 'Substance Use Disorder Assessment', 'route' => 'substance_use_assessment'],
                ['name' => 'Eating Disorder Assessment', 'route' => 'eating_disorder_assessment'],
                ['name' => 'Self-Harm Challenges Assessment', 'route' => 'self_harm_assessment'],
                ['name' => 'Attention Issues Assessment', 'route' => 'attention_issues_assessment'],
            ],
        ]);
    }

    // ✅ Individual assessment methods
    public function anxiety()
    {
        return Inertia::render('Assessment/AnxietyAssessment');
    }

    public function depression()
    {
        return Inertia::render('Assessment/DepressionAssessment');
    }

    public function ptsd()
    {
        return Inertia::render('Assessment/PTSDAssessment');
    }

    public function stress()
    {
        return Inertia::render('Assessment/StressAssessment');
    }

    public function substanceUse()
    {
        return Inertia::render('Assessment/SubstanceUseAssessment');
    }

    public function eatingDisorder()
    {
        return Inertia::render('Assessment/EatingDisorderAssessment');
    }

    public function selfHarm()
    {
        return Inertia::render('Assessment/SelfHarmAssessment');
    }

    public function attentionIssues()
    {
        return Inertia::render('Assessment/AttentionIssuesAssessment');
    }

    // ✅ Store Anxiety Assessment Responses & Redirect
    public function storeAnxiety(Request $request)
    {
        $validatedData = $request->validate([
            'responses' => 'required|array',
            'responses.*' => 'integer|min:1|max:4',
        ]);

        $user = auth()->user();
        $totalScore = array_sum($validatedData['responses']);
        $severity = $this->determineSeverity($totalScore, 'Anxiety');

        $assessment = MentalHealthAssessment::create([
            'user_id' => $user->id,
            'assessment_type' => 'Anxiety',
            'responses' => json_encode($validatedData['responses']),
            'total_score' => $totalScore,
            'severity' => $severity['level'],
            'impact' => $severity['impact'],
        ]);

        return $assessment
            ? redirect('/assessment/anxiety/results')
            : redirect()->route('anxiety_assessment')->with('error', 'Failed to save assessment.');
    }

    // ✅ Store Depression Assessment Responses & Redirect
    public function storeDepression(Request $request)
    {
        $validatedData = $request->validate([
            'responses' => 'required|array',
            'responses.*' => 'integer|min:1|max:4',
        ]);

        $user = auth()->user();
        $totalScore = array_sum($validatedData['responses']);
        $severity = $this->determineSeverity($totalScore, 'Depression');

        $assessment = MentalHealthAssessment::create([
            'user_id' => $user->id,
            'assessment_type' => 'Depression',
            'responses' => json_encode($validatedData['responses']),
            'total_score' => $totalScore,
            'severity' => $severity['level'],
            'impact' => $severity['impact'],
        ]);

        return $assessment
            ? redirect('/assessment/depression/results')
            : redirect()->route('depression_assessment')->with('error', 'Failed to save assessment.');
    }

    // ✅ Show Anxiety Assessment Results
    public function showAnxietyResults()
    {
        return $this->showResults('Anxiety', 'Assessment/AnxietyResults');
    }

    // ✅ Show Depression Assessment Results
    public function showDepressionResults()
    {
        return $this->showResults('Depression', 'Assessment/DepressionResults');
    }

    // ✅ Generic function to fetch latest & past results for an assessment type
    private function showResults($type, $view)
    {
        $user = auth()->user();
        $latestAssessment = MentalHealthAssessment::where('user_id', $user->id)
            ->where('assessment_type', $type)
            ->latest()
            ->first();

        if (!$latestAssessment) {
            return redirect()->route(strtolower($type) . '_assessment')
                ->with('error', 'No assessment results found.');
        }

        // Get all past assessments of this type
        $pastAssessments = MentalHealthAssessment::where('user_id', $user->id)
            ->where('assessment_type', $type)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render($view, [
            'total_score' => $latestAssessment->total_score ?? 'N/A',
            'severity' => $latestAssessment->severity ?? 'Unknown',
            'impact' => $latestAssessment->impact ?? 'Not provided',
            'latestAssessment' => $latestAssessment,
            'pastAssessments' => $pastAssessments,
        ]);
    }

    // ✅ Fetch User's Past Assessments for Dashboard
    public function history()
    {
        $user = auth()->user();
        $assessments = MentalHealthAssessment::where('user_id', $user->id)
            ->whereIn('assessment_type', ['Anxiety', 'Depression']) // Include both
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('AssessmentHistory', [
            'assessments' => $assessments,
        ]);
    }

    // ✅ Determine severity level based on type & score
    private function determineSeverity($score, $type)
    {
        if ($type === 'Anxiety') {
            if ($score <= 10) {
                return ['level' => 'Minimal Anxiety', 'impact' => 'Little to no impact on daily life'];
            } elseif ($score <= 20) {
                return ['level' => 'Mild Anxiety', 'impact' => 'Occasional distress, manageable'];
            } elseif ($score <= 30) {
                return ['level' => 'Moderate Anxiety', 'impact' => 'Frequent distress, affects daily routine'];
            } else {
                return ['level' => 'Severe Anxiety', 'impact' => 'Significant distress, major impact on daily life'];
            }
        } elseif ($type === 'Depression') {
            if ($score <= 10) {
                return ['level' => 'Minimal Depression', 'impact' => 'Little to no impact on daily life'];
            } elseif ($score <= 20) {
                return ['level' => 'Mild Depression', 'impact' => 'Occasional distress, manageable'];
            } elseif ($score <= 30) {
                return ['level' => 'Moderate Depression', 'impact' => 'Frequent distress, affects daily routine'];
            } else {
                return ['level' => 'Severe Depression', 'impact' => 'Significant distress, major impact on daily life'];
            }
        }

        return ['level' => 'Unknown', 'impact' => 'Not provided'];
    }
}
