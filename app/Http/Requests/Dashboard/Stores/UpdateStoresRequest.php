<?php

namespace App\Http\Requests\Dashboard\Stores;

use Illuminate\Foundation\Http\FormRequest;


class UpdateStoresRequest extends FormRequest
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
            'name'     => 'required|string|max:150',
            'desc'     => 'required',
        ];
        if(request()->hasFile('logo')) {
            $return['logo'] = "required|image";
        }
        if(request()->hasFile('cover')) {
            $return['cover'] = "required|image";
        }
        return $return;
    }
}
