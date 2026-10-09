<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;
use Inertia\Response;

class ForgotPasswordController extends Controller
{
    /**
     * Show the form for requesting a password reset link.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    /**
     * Email a password reset link to the user.
     *
     * The same message is shown whether or not the email exists, so the form
     * can't be used to find out which emails are registered.
     */
    public function store(ForgotPasswordRequest $request): RedirectResponse
    {
        $status = Password::sendResetLink($request->safe()->only('email'));

        if ($status === Password::ResetThrottled) {
            return back()->withErrors(['email' => __($status)]);
        }

        return back()->with('success', 'If an account exists for that email, we have sent a password reset link.');
    }
}
