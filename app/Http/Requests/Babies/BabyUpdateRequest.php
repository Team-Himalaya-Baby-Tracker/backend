<?php

namespace App\Http\Requests\Babies;

use Illuminate\Foundation\Http\FormRequest;

class BabyUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable'],
            'gender' => ['nullable'],
            'photo' => ['image', 'nullable'],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->name === 'null') {
            $this->merge(['name' => null]);
        }
        if ($this->gender === 'null') {
            $this->merge(['gender' => null]);
        }
        if ($this->photo === 'null') {
            $this->merge(['photo' => null]);
        }
        if ($this->birth_date === 'null') {
            $this->merge(['birth_date' => null]);
        }
        if ($this->name === 'null') {
            $this->merge(['name' => null]);
        }
    }
}
