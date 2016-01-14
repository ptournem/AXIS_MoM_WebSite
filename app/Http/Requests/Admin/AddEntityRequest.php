<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AddEntityRequest extends Request
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
            'entity-type' => 'required|min:5|max:20|alpha',
            'entity-name' => 'required|min:5|max:20|alpha',
            'entity-description' => 'required|min:5|max:200',
            'entity-image' => 'required|min:5|max:200'
        ];
    }
}
