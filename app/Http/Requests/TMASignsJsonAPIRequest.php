<?php

namespace App\Http\Requests;

use App\Classes\TMASigns\Settings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TMASignsJsonAPIRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation by setting default values
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'format' => $this->get('format') ?? 'tga',
            'size' => $this->get('size') ?? 2,
            'options' => $this->get('options') ?? [],
            'text' => $this->get('text') ?? 'Hello world!',
            'subtext' => $this->get('subtext') ?? null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'format' => ['required', 'string', Rule::in(Settings::ALLOWEDFILETYPES)],
            'size' => ['required', 'numeric', Rule::in(Settings::ALLOWEDSIZES)],
            'options' => ['sometimes', 'array'],
            'text' => ['bail', 'required', 'string', 'max:32'],
            'subtext' => ['sometimes', 'nullable', 'string', 'max:64'],
        ];
    }
}
