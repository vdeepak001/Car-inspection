<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Show the contact page.
     */
    public function create(): View
    {
        return view('contact', [
            'title' => 'Contact Us',
        ]);
    }

    /**
     * Store a message from the contact form.
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        ContactMessage::query()->create($request->safe()->only(['name', 'email', 'phone', 'message']));

        return redirect()
            ->route('contact')
            ->with('status', 'Message sent. We will reply within 24 hours.');
    }
}
