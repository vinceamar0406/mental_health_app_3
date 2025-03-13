<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScreeningResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ScreeningController extends Controller
{
    public function store(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'responses' => 'required|array|min:5',
            'responses.*' => 'required|string|min:10', // Ensure each response is meaningful
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Store the responses in the database
        $screeningResponse = ScreeningResponse::create([
            'user_id' => Auth::id(),
            'responses' => $request->input('responses'),
        ]);

        // Send the responses to the Flask API
        $flaskApiUrl = env('FLASK_API_URL', 'http://127.0.0.1:5000/predict');
        $response = Http::post($flaskApiUrl, ['responses' => $request->input('responses')]);

        // Log the response from Flask API to debug
        \Log::info('Flask API Response:', $response->json());

        // Handle the response from Flask API
        if ($response->failed()) {
            // Log the error or return a detailed message
            return response()->json(['error' => 'Flask API error. Please try again later.'], 500);
        }

        // Extract the predicted condition from the API response
        $predictedCondition = $response->json()['predicted_condition'] ?? 'No result available';

        // Log the state of the $screeningResponse before the update
        \Log::info('Before Update:', $screeningResponse->toArray());

        // Save the predicted condition to the database
        $screeningResponse->update([
            'predicted_condition' => $predictedCondition,
        ]);

        // Log the state of the $screeningResponse after the update
        \Log::info('After Update:', $screeningResponse->toArray());

        // Redirect the user to the result page
        return redirect()->route('screening.result');
    }

    public function showResult()
    {
        // Get the latest screening response for the current user
        $screeningResponse = ScreeningResponse::where('user_id', Auth::id())->latest()->first();

        // Check if screeningResponse exists and has the predicted condition
        $predictedCondition = $screeningResponse ? $screeningResponse->predicted_condition : 'No result available.';

        // Return Inertia response with the result
        return inertia('ScreeningResult', [
            'message' => 'Screening responses saved successfully.',
            'predicted_condition' => $predictedCondition,
        ]);
    }
}
