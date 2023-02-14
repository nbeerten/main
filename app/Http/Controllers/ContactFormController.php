<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactForm;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    /**
     * Send contact form email
     *
     * @return void
     */
    public function post(ContactFormRequest $request)
    {
        $validated = $request->safe()->except('cf-turnstile-response');

        Mail::to(config('mail.from.address'))
            ->send(new ContactForm($validated));

        return back()->with('success', 'Successfully send the message!');
    }
}
