<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class OTPRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required'
        ];

    }

    public function messages()
    {
        return [
            'email.required'        => __('Email/Phone is required!'),
        ];
    }

    public function authorize()
    {
        return true;
    }
}
