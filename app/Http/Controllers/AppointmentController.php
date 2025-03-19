<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\MentalHealthAssessment;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // Request an Appointment
    public function requestAppointment(Request $request)
    {
        $user = Auth::user();
        $assessmentId = $request->assessment_id;

        // Check if an appointment already exists for this assessment and user
        $existingAppointment = Appointment::where('user_id', $user->id)
            ->where('assessment_id', $assessmentId)
            ->where('status', 'pending')
            ->first();

        if ($existingAppointment) {
            return redirect()->route('assessment.history')->with('status', 'Appointment requested successfully.');
        }

        // Create new appointment if no existing request is found
        $appointment = new Appointment();
        $appointment->user_id = $user->id;
        $appointment->assessment_id = $assessmentId;
        $appointment->status = 'pending';
        $appointment->save();

        return response()->json(['message' => 'Appointment requested successfully!'], 201);
    }

    // Approve an Appointment (Admin)
    public function approveAppointment(Request $request, Appointment $appointment)
{
    // Ensure only admins can approve
    if (Auth::user()->role !== 'admin') {
        return response()->json(['error' => 'Unauthorized access.'], 403);
    }

    // Validate the incoming request to ensure the scheduled date is provided and valid
    $request->validate([
        'scheduled_at' => 'required|date|after:today', // Ensure it's a valid future date
    ]);

    // Set the appointment status to approved and store the scheduled date
    $appointment->status = 'approved';
    $appointment->scheduled_at = $request->input('scheduled_at'); // Set the scheduled date
    $appointment->save();

    return response()->json([
        'message' => 'Appointment approved and scheduled successfully.',
        'appointment' => $appointment, // Return the updated appointment with the scheduled date
    ]);
}
public function completeAppointment(Appointment $appointment)
{
    // Ensure only admins can complete
    if (Auth::user()->role !== 'admin') {
        return response()->json(['error' => 'Unauthorized access.'], 403);
    }

    $appointment->status = 'completed';
    $appointment->save();

    return response()->json(['message' => 'Appointment marked as completed.']);
}

}

