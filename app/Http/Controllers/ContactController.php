<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function create(): Response
    {
        return Inertia::render('ContactUs', [
            'message' => 'Ye Contact Us page hai!',
        ]);
    }

    /**
     * Store a new contact message.
     */
    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        ContactMessage::create($request->validated());

        return to_route('contact-us')->with('success', 'Thank you! Your message has been sent.');
    }
}
