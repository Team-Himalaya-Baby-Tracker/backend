<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BreastFeedRecordStoreRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'left_boob' => 'required|boolean',
            'right_boob' => 'required|boolean',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:255',
		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
