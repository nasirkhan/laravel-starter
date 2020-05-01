<?php

namespace Modules\Tag\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class TagsRequest extends FormRequest
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
            'name' => 'required|max:191|unique:tags,name,'.$this->tag,
            'slug' => 'nullable|max:191|unique:tags,slug,'.$this->tag,
        ];
    }
}
