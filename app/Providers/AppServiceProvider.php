<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure Inertia shares authentication data
        Inertia::share([
            'auth' => function () {
                return [
                    'user' => Auth::check() ? [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'role' => Auth::user()->role, // Include role if needed
                    ] : null,
                ];
            },
        ]);

        // Prefetch assets for better performance
        Vite::prefetch(concurrency: 3);
    }
}
