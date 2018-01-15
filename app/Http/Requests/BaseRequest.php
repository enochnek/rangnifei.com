<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function getErrorsCount()
    {

        return $this->getErrors() == null ? 0 : $this->getErrors()->count();
    }

    public function getErrors() {

        $validator = $this->getValidatorInstance();
        if ($validator->errors()->count() == 0) return null;
        return $validator->errors();
    }

    public function changeRequest(BaseRequest $request)
    {

        $newRequest = BaseRequest::create($request->getUri(), $request->method, $request->all(),
            $request->cookie, $request->file, $request->server, $request->content);
        return $newRequest;

    }

    protected function failedValidation(Validator $validator)
    {

        return $validator->errors();
    }
}
