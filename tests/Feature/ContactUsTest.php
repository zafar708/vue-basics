<?php

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('the contact us page can be rendered', function () {
    $this->get('/contact-us')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('ContactUs'));
});

test('a visitor can send a contact message', function () {
    $this->post('/contact-us', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'subject' => 'Hello',
        'message' => 'I would like to know more.',
    ])
        ->assertRedirect('/contact-us')
        ->assertSessionHas('success', 'Thank you! Your message has been sent.');

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'subject' => 'Hello',
        'message' => 'I would like to know more.',
    ]);
});

test('all contact fields are required', function () {
    $this->post('/contact-us', [])
        ->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
            'subject' => 'The subject field is required.',
            'message' => 'The message field is required.',
        ]);

    $this->assertDatabaseEmpty('contact_messages');
});

test('a contact message is rejected with an invalid email', function () {
    $this->post('/contact-us', [
        'name' => 'Test User',
        'email' => 'not-an-email',
        'subject' => 'Hello',
        'message' => 'I would like to know more.',
    ])->assertSessionHasErrors(['email' => 'The email field must be a valid email address.']);

    $this->assertDatabaseEmpty('contact_messages');
});

test('a contact message is rejected when it is longer than 5000 characters', function () {
    $this->post('/contact-us', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'subject' => 'Hello',
        'message' => str_repeat('a', 5001),
    ])->assertSessionHasErrors(['message' => 'The message field must not be greater than 5000 characters.']);

    $this->assertDatabaseEmpty('contact_messages');
});

test('contact messages are limited to five per minute', function () {
    $payload = ContactMessage::factory()->make()->toArray();

    for ($attempt = 1; $attempt <= 5; $attempt++) {
        $this->post('/contact-us', $payload)->assertRedirect('/contact-us');
    }

    $this->post('/contact-us', $payload)->assertTooManyRequests();

    $this->assertDatabaseCount('contact_messages', 5);
});
