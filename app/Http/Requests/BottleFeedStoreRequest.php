<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BottleFeedStoreRequest extends FormRequest
{
	public function rules()
	{
		return [
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
		];
	}

	public function authorize()
	{
		return true;
	}
}
