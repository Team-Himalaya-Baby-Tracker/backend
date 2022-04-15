<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiaperDataStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', 'array'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
