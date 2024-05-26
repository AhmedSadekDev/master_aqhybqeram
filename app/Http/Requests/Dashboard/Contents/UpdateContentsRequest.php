<?php

namespace App\Http\Requests\Dashboard\Contents;

use Illuminate\Foundation\Http\FormRequest;


class UpdateContentsRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'title'  => 'required|string|max:150',
            'value'  => 'required',
        ];
    }
}
