<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'name' => 'required|string|max:50',
            'email' => 'required',
            'password' => 'required|confirmed|min:6',
        ];

    }

    public function messages()
    {
        return [
            'email.required'   => __('Email/phone is required!'),
            'name.required'    => __('Name is required!'),
            'password.required'=> __('Password is required'),
            'password.confirmed'=> __('Confirm Password does not match'),
            'password.min'      => __('Password should be minimum 6 Character'),
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
