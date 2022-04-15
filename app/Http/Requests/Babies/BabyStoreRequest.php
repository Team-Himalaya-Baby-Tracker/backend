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
            'photo' => ['image' , 'nullable'],

		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
