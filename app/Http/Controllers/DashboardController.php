<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Show the logged-in user's dashboard.
     */
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'memberSince' => $request->user()->created_at->toFormattedDateString(),
            'totalPosts' => Post::visibleTo($request->user())->count(),
        ]);
    }
}
