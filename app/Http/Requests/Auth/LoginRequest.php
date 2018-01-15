<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/9/20
 * Time: 0:04
 */

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'username' => 'required|strlen:2,16',
            'password' => 'required|min:6|max:20|',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}