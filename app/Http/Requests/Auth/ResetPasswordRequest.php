<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'             => 'required',
            'password'          => 'required|confirmed|min:6'
        ];

    }

    public function messages()
    {
        return [
            'email.required'            => _trans('landlord.Email/phone is required!'),
            'password.required'         => _trans('landlord.Password is required'),
            'password.confirmed'        => _trans('landlord.Confirm Password does not match'),
        ];
    }
}
