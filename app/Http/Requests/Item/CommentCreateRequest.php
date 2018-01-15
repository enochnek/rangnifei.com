<?php

namespace App\Http\Requests\Item;

use App\Http\Requests\BaseRequest;

class CommentCreateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'item_comment_content' => 'required|strlen:5,72',
            'parent' => 'integer',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
