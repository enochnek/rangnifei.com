<?php

namespace App\Http\Requests\Item;

use App\Http\Requests\BaseRequest;

class ItemCreateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'item_cataid' => 'required|integer',
            'item_gameid' => 'required|integer',
            'item_title' => 'required',
            'item_description' => 'required',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
