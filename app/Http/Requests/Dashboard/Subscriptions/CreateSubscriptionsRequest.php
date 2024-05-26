<?php

namespace App\Http\Requests\Dashboard\Subscriptions;

use Illuminate\Foundation\Http\FormRequest;


class CreateSubscriptionsRequest extends FormRequest
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
            'name'   => 'required|string|max:150',
            'price'  => 'required|numeric',
            'month'  => 'required|numeric',
            'image'  => 'required|image|mimes:png,jpg'
        ];
    }
}
