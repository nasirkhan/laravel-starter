<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOTPRequest extends FormRequest
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
            'otp'       => 'required'
        ];

    }

    public function messages()
    {
        return [
            'email.required'        => 'Email/Phone is required!',
            'otp.required'          => 'OTP code is required!',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
