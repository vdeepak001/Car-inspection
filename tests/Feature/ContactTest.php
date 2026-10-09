<?php

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('shows the contact page', function () {
    $this->get(route('contact'))
        ->assertOk()
        ->assertSee('Get in Touch')
        ->assertSee('Send Us a Message');
});

test('stores a contact message', function () {
    $this->post(route('contact.store'), [
        'name' => 'Ava Lane',
        'email' => 'ava@example.com',
        'phone' => '5551234567',
        'message' => 'I want a pre delivery inspection.',
    ])->assertRedirect(route('contact'));

    $message = ContactMessage::query()->first();

    expect($message)->not->toBeNull()
        ->and($message->email)->toBe('ava@example.com')
        ->and($message->message)->toBe('I want a pre delivery inspection.');
});
