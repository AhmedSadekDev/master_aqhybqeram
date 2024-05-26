<?php

namespace App\Http\Requests\API\Auth;

use App\Helpers\JsonFormRequest;

class RegisterRequest extends JsonFormRequest
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
            'first_name' => 'required',
            'last_name'  => 'required',
            'phone'      => 'required',
            'email'      => 'required|email',
            'password'   => 'required|min:8',
            'devices_token'  => 'required',
        ];
    }
}
