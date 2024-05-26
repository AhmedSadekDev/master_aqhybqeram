<?php

namespace App\Http\Requests\Dashboard\Coupons;

use Illuminate\Foundation\Http\FormRequest;

class CreateCouponsRequest extends FormRequest
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
            'store_id'   => 'required|exists:stores,id',
            'name'       => 'required',
            'desc'       => 'required',
            'code'       => 'required',
            'expire'     => 'required',
        ];
    }
}
