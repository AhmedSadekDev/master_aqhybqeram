<?php

namespace App\Http\Requests\Dashboard\Categories;

use Illuminate\Foundation\Http\FormRequest;


class UpdateCategoriesRequest extends FormRequest
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
        $return = [
            'name'  => 'required|string|max:150',
        ];
        if(request()->has('image') && !is_null(request('image'))) {
            $return['image'] = 'required|image|mimes:png,jpg';
        }
        return $return;
    }
}
