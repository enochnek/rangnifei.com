<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class PayRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'optionid' => 'required|integer',
            'amount' => 'required|integer',
            'singleCost' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
