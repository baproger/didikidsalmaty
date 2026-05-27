<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'max:150'],
            'phone'     => ['nullable', 'string', 'max:30'],
            'child_age' => ['nullable', 'string', 'max:20'],
            'message'   => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => __('validation.name_required'),
            'email.required'   => __('validation.email_required'),
            'email.email'      => __('validation.email_invalid'),
            'message.required' => __('validation.message_required'),
            'message.min'      => __('validation.message_min'),
        ];
    }
}
