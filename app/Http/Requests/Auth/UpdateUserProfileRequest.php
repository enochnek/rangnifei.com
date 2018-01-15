<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class UpdateUserProfileRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'nickname' => 'string:nullable|strlen:2,8',
            'phone' => 'digits:11',
            'email' => 'email',
            'alipay' => 'strlen:0,16',
            'avatar' => 'strlen:0,255',
            'qq' => 'digits_between:0,12',
            'wechat' => 'strlen:0,24',
            'sex' => 'digits:1',
            'introduction' => 'strlen:0,32',
        ];
    }

    public function messages()
    {
        return [
            'introduction.strlen' => 'OUT_LENGTH',
            'email.email' => 'EMAIL',
            'qq.digits_between' => 'QQ格式不正确...'
        ];
    }
}
