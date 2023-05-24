<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ApiLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required',
            'password'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required'        => __('Email/Phone is required!'),
            'password.required'     => __('Password is required'),
        ];
    }

    public function authorize()
    {
        return true;
    }
}
