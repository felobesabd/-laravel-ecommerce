<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:9',
        ];
    }

    public function messages()
    {
        return [
            'email.require' => 'The email field is required..',
            'email.email' => 'The email must be a valid email address..',
            'password.require' => 'The password field is required..',
            'password.min' => 'The password must be at least 9 characters..',
        ];
    }
}
