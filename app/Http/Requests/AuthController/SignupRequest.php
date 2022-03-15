<?php

namespace App\Http\Requests\AuthController;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'min:2'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'type' => ['required', 'in:parent,baby_sitter'],
            'birth_date' => ['required', 'before:-13 years'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
