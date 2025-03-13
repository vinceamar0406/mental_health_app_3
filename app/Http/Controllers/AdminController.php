<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    public function index(): Response
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized'); // Prevent access
        }

        return Inertia::render('AdminDashboard');
    }
}
