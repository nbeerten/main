<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:128'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:64'],
            'message' => ['required', 'string'],
            'cf-turnstile-response' => ['required', Rule::turnstile()],
        ];
    }
}
