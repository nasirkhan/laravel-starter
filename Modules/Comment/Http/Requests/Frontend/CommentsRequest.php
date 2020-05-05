<?php

namespace Modules\Comment\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class CommentsRequest extends FormRequest
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
            // 'name'    => 'nullable|max:191',
            'comment' => 'required',
            'user_id' => 'required',
        ];
    }
}
