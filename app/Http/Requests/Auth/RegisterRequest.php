<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'phone' => 'required|digits:11|unique:user',
            'msgcode' => 'digits:6',
            'username' => 'required|strlen:2,8|unique:user',
            'password' => 'required|min:6|max:20|',
        ];
    }

    public function messages()
    {
        return [
            'phone.unique' => 'REGISTER_PHONETAKEN',
            'username.unique' => 'REGISTER_USERTAKEN',
        ];
    }
}
