<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepressionAssessmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PTSDAssessmentController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\StressAssessmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\AssessmentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// ✅ Unified Dashboard (Users & Admins)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    // ✅ Mental Health Screening (Initial Prediction)
    Route::get('/screening', [PredictionController::class, 'index'])->name('screening');
    Route::get('/mental-health-screening', [PredictionController::class, 'index'])->name('mental_health_screening');

    // ✅ Save responses before sending to Flask
    Route::post('/screening/submit', [ScreeningController::class, 'store'])->name('screening.submit');
    Route::get('/screening/result', [ScreeningController::class, 'showResult'])->name('screening.result');

    // ✅ Assessment & Evaluation (Severity Assessment)
    Route::get('/assessment', [AssessmentController::class, 'index'])->name('assessment');

    // ✅ Assessment History Route (Fixed)
    Route::get('/assessment/history', [AssessmentController::class, 'history'])->name('assessment.history');

    // ✅ Assessment Hub - Displays available severity assessment options
    Route::get('/assessment-hub', [AssessmentController::class, 'hub'])->name('assessment_hub');

    // ✅ Individual Assessment Routes
    Route::get('/assessment/anxiety', [AssessmentController::class, 'anxiety'])->name('anxiety_assessment');
    Route::get('/assessment/depression', fn() => Inertia::render('Assessment/DepressionAssessment'))->name('depression_assessment');
    Route::get('/assessment/ptsd', fn() => Inertia::render('Assessment/PTSDAssessment'))->name('ptsd_assessment');
    Route::get('/assessment/stress-related', fn() => Inertia::render('Assessment/StressAssessment'))->name('stress_assessment');
    Route::get('/assessment/substance-use', fn() => Inertia::render('Assessment/SubstanceUseAssessment'))->name('substance_use_assessment');
    Route::get('/assessment/eating-disorder', fn() => Inertia::render('Assessment/EatingDisorderAssessment'))->name('eating_disorder_assessment');
    Route::get('/assessment/self-harm', fn() => Inertia::render('Assessment/SelfHarmAssessment'))->name('self_harm_assessment');
    Route::get('/assessment/attention-issues', fn() => Inertia::render('Assessment/AttentionIssuesAssessment'))->name('attention_issues_assessment');

    Route::post('/assessment/anxiety/store', [AssessmentController::class, 'storeAnxiety'])->name('assessment.anxiety.store');
    Route::get('/assessment/anxiety/results', [AssessmentController::class, 'showAnxietyResults'])->name('assessment.anxiety.results');

    Route::post('/assessment/depression/store', [DepressionAssessmentController::class, 'store'])->name('assessment.depression.store');
    Route::get('/assessment/depression/results', [DepressionAssessmentController::class, 'results'])->name('depression.results');

    Route::post('/assessment/ptsd/store', [PTSDAssessmentController::class, 'store'])->name('ptsd.store');
    Route::get('/assessment/ptsd/results', [PTSDAssessmentController::class, 'showPTSDResults'])->name('ptsd.results');

    Route::post('/assessment/stress/store', [StressAssessmentController::class, 'store'])->name('stress.store');
    Route::get('/assessment/stress/results', [StressAssessmentController::class, 'results'])->name('stress.results');
});

// ✅ Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', fn() => Inertia::render('Dashboard'))->name('admin.dashboard');
    Route::get('/admin/results', [AdminController::class, 'results'])->name('admin.results');
});

// ✅ Profile Routes (Accessible by all authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Authentication Routes
require __DIR__.'/auth.php';
