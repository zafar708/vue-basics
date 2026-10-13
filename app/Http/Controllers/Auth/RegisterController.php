<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Create a new user account and log the user in.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());
        $user->assignRole('author');

        Auth::login($user);

        $request->session()->regenerate();

        return to_route('dashboard')->with('success', 'Welcome! Your account has been created.');
    }
}
