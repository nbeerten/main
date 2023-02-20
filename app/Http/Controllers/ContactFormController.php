<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactForm;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    /**
     * Send contact form email
     */
    public function post(ContactFormRequest $request): RedirectResponse
    {
        $validated = $request->safe()->except('cf-turnstile-response');

        Mail::to(config('mail.from.address'))
            ->send(new ContactForm($validated));

        return back()->with('success', 'Successfully send the message!');
    }
}
