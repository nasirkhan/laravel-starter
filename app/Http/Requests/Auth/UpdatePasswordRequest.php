<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password'              => 'required|string|min:6',
            'new_password'          => 'required|string|min:6',
            'confirm_password'      => 'required|string|min:6',
        ];

    }

    public function messages()
    {
        return [
            'password.required'                 => __('Password is required!'),
            'password.min'                      => __('Password length must be 6 character or greater!'),
            'new_password.required'             => __('New password is required!'),
            'new_password.min'                  => __('New password length must be 6 character or greater!'),
            'confirm_password.required'         => __('Confirm password is required!'),
            'confirm_password.min'              => __('Confirm password length must be 6 character or greater!!'),
        ];
    }


}
