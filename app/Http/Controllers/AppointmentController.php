<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Appointments', [
            'appointments' => [] // Fetch appointments from the database here
        ]);
    }
}
