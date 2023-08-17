<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
   /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
   */
   public function rules(): array
   {
      return [
         'firstname' => 'required|string|min:3|max:255',
         'lastname' => 'required|string|min:3|max:255',
         'email' => 'required|email|unique:sellers,email',
         'password' => 'required|string|min:8|max:255',
         'confirm_password' => 'required|string|min:8|max:255|same:password',
         'phone' => 'required|string|min:10|max:255|unique:sellers,phone',
         'terms' => 'required',
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
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'email' => 'Email',
			'password' => 'Password',
			'confirm_password' => 'Confirm Password',
			'phone' => 'Phone',
			'terms' => 'Terms',
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
			'firstname.required' => ':attribute harus diisi.',
			'firstname.string' => ':attribute harus berupa string.',
			'firstname.min' => ':attribute minimal 3 karakter.',
			'firstname.max' => ':attribute maksimal 255 karakter.',
			'lastname.required' => ':attribute harus diisi.',
			'lastname.string' => ':attribute harus berupa string.',
			'lastname.min' => ':attribute minimal 3 karakter.',
			'lastname.max' => ':attribute maksimal 255 karakter.',
			'email.required' => ':attribute harus diisi.',
			'email.email' => ':attribute harus berupa email.',
			'email.unique' => ':attribute sudah terdaftar.',
			'password.required' => ':attribute harus diisi.',
			'password.string' => ':attribute harus berupa string.',
			'password.min' => ':attribute minimal 8 karakter.',
			'password.max' => ':attribute maksimal 255 karakter.',
			'confirm_password.required' => ':attribute harus diisi.',
			'confirm_password.string' => ':attribute harus berupa string.',
			'confirm_password.min' => ':attribute minimal 8 karakter.',
			'confirm_password.max' => ':attribute maksimal 255 karakter.',
			'confirm_password.same' => ':attribute tidak sama dengan password.',
			'phone.required' => ':attribute harus diisi.',
			'phone.string' => ':attribute harus berupa string.',
			'phone.min' => ':attribute minimal 10 karakter.',
			'phone.max' => ':attribute maksimal 255 karakter.',
			'phone.unique' => ':attribute sudah terdaftar.',
			'terms.required' => 'Anda harus menyetujui syarat & ketentuan.',
		];
	}
}
