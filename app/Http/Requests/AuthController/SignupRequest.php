<?php

namespace App\Http\Requests\AuthController;

use App\Rules\isValidPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'min:2'],
            'email' => ['required', 'email:dns,rfc', 'unique:users,email'],
            'password' => ['required', 'min:8', new isValidPasswordRule()],
            'type' => ['required', 'in:parent,baby_sitter'],
            'birth_date' => ['required', 'before:-14 years' ,'date'],
            'description' => ['required_if:type,baby_sitter', 'min:10'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
