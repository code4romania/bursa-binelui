<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'text' => ['required', 'string', 'max:5000'],
        ], [
            'name.required' => __('validation.required', ['attribute' => __('name_last_name')]),
            'email.required' => __('validation.required', ['attribute' => __('email')]),
            'text.required' => __('validation.required', ['attribute' => __('message_label')]),
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['text'],
        ]);

        return redirect()
            ->route('contact')
            ->with('success', __('contact_message_sent'));
    }
}
