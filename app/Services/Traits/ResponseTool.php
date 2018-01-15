<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 10:15
 */

namespace App\Services\Traits;

use App\Http\Requests\BaseRequest;
use App\Utils\Responsor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

trait ResponseTool
{

    protected static function responseMsgCode($statusStr, $data = null) {

        if (config('R.' . $statusStr) === null) {
            return self::responseMsg(1, $statusStr, $data);
        } else {
            return self::responseMsg(config('R.' . $statusStr), config('R.' . $statusStr . '_MSG'), $data);
        }
    }

    protected static function responseMsg($status, $message, $data = null) {

        $responsor = Responsor::getInstance();
        $responsor->setStatus($status)
            ->setMessage($message)
            ->setData($data);

        return $responsor->toJson();
    }

    protected static function responseRequestErrorAll(BaseRequest $request) {

        if ($request->getErrorsCount()) {
            $error = $request->getErrors();
            return self::responseMsgCode($error);
        }
    }

    protected static function responseRequestError(BaseRequest $request) {

        if ($request->getErrorsCount()) {
            $code = $request->getErrors()->first();
            return self::responseMsgCode($code);
        }
    }
}