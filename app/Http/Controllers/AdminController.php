<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Models\Assessment;
use App\Models\Appointment;
use App\Models\Report;

class AdminController extends Controller
{
    // ✅ Admin Dashboard
    public function index(): Response
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized'); // Prevent non-admin access
        }

        $totalUsers = User::count(); // Fetch total users

        return Inertia::render('AdminHome', [
            'totalUsers' => $totalUsers // Pass data to Vue component
        ]);
    }

    // ✅ Fetch Total Users
    public function users()
{
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized'); // Prevent non-admin access
    }

    $users = User::all(); // Fetch all users

    return Inertia::render('UserList', [ 'users' => $users]);

}


    // ✅ Fetch Total Assessments
    public function assessments()
{
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized');
    }

    // Fetch all assessments with user details
    $assessments = Assessment::with('user')->get();

    return Inertia::render('AssessmentTaken', [
        'assessments' => $assessments]);
}

    // ✅ Fetch Total Appointments
    public function appointments()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return response()->json(['totalAppointments' => Appointment::count()]);
    }

    // ✅ Fetch Total Reports
    public function reports()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return response()->json(['totalReports' => Report::count()]);
    }
}
