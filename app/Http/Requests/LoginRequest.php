<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
   /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
   */
   public function rules(): array
   {
      return [
         'email' => 'required|email|exists:sellers,email',
         'password' => 'required|string',
      ];
   }

	/**
	  * Get the validation attributes that apply to the request.
	  *
	  * @return array<string, string>
	*/
	public function attributes(): array
	{
		return [
			'email' => 'Email',
			'password' => 'Password',
		];
	}

	/**
	  * Get the validation messages that apply to the request.
	  *
	  * @return array<string, string>
	*/
	public function messages(): array
	{
		return [
			'email.required' => ':attribute harus diisi.',
			'email.email' => ':attribute harus berupa email.',
			'email.exists' => ':attribute tidak ditemukan.',
			'password.required' => ':attribute harus diisi.',
		];
	}
}
