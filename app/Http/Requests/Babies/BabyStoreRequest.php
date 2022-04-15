<?php

namespace App\Http\Requests\Babies;

use Illuminate\Foundation\Http\FormRequest;

class BabyStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'gender' => ['nullable'],
            'photo' => ['image', 'nullable'],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
        ];
    }

    protected function prepareForValidation()
    {
        if($this->phono === 'null' || $this->phono === '') {
            $this->merge(['photo' => null]);
        }
    }

    public function authorize(): bool
    {
        return true;
    }
}
