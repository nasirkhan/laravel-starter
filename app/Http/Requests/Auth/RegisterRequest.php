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
            'password' => 'required|confirmed|min:6'
        ];

    }

    public function messages()
    {
        return [
            'email.required'   => _trans('landlord.Email/phone is required!'),
            'name.required'    => _trans('landlord.Name is required!'),
            'password.required'=> _trans('landlord.Password is required'),
            'password.confirmed'=> _trans('landlord.Confirm Password does not match'),
            'password.min'      => _trans('landlord.Password should be minimum 6 Character'),
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
