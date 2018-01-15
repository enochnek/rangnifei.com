<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RestPassRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'phone' => 'required|digits:11',
            'msgcode' => 'digits:6',
            'password' => 'required|min:6|max:20|',
        ];
    }

    public function messages()
    {
        return [
            'phone.unique' => 'RESET_PHONE_NOT_EXIST_MSG',
        ];
    }
}
