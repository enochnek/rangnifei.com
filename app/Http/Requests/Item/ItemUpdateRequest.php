<?php

namespace App\Http\Requests\Item;

use App\Http\Requests\BaseRequest;

class ItemUpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'itemid' => 'required|string:1,11',
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
