<?php

namespace App\Http\Requests;

use App\Rules\isValidPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['nullable', 'min:2'],
            'email' => ['nullable', 'email:dns,rfc', 'unique:users,email'],
            'password' => ['nullable', 'min:8', new isValidPasswordRule()],
            'birth_date' => ['nullable', 'before:-14 years' ,'date'],
            'description' => ['nullable', 'min:10'],
        ];
    }

    public function validated()
    {
        $validated = parent::validated();
        if ($this->user()->type === 'parent') {
            unset($validated['description']);
        }
        return $validated;
    }
}
