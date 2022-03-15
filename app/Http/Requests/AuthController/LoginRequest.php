<?php

namespace App\Http\Requests\AuthController;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['email', 'required'],
            'password' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
