<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 11:05
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;

use App\Http\Requests\Auth\RestPassRequest;
use App\Repositories\Interfaces\AuthInterface;
use App\Services\SMS\SendSMS;
use App\Services\User\AuthAPI;
use App\Services\User\UserAPI;
use App\User;
use App\Utils\Format;
use Illuminate\Http\Request;

class ResetPassController extends BaseController
{
    public function sendRegisterSMS(Request $request)
    {
        $phone = $request->input('phone');

        if ($phone == null) {
            return self::responseMsgCode('REGISTER_PHONETAKEN');
        }

        if (AuthAPI::getByPhone($phone) == null) {
            return self::responseMsgCode('RESET_PHONE_NOT_EXIST');
        }

        $sms = new SendSMS();
        $msgcode = $sms->sendResetPasswordSMS($phone);

        AuthAPI::createTempPhone($phone, $msgcode);

        return self::responseMsgCode('OK');
    }

    public function resetPass(RestPassRequest $request)
    {


        if (self::hasRequestError($request)) {
            return self::responseRequestError($request);
        }

        $msgcode = $request->input('msgcode');
        $keys = ['phone', 'password'];
        $param = Format::filter($request->all(), $keys);

        $tempPhone = AuthAPI::getByPhone($param['phone']);
        if ($tempPhone == null) {
            return self::responseMsgCode('REGISTER_CODEWRONG');
        }

        if ((time() - strtotime($tempPhone->updated_at)) > 3600) {
            return self::responseMsgCode('REGISTER_CODETIMEOUT');
        }

        if ($tempPhone->msgcode != $msgcode) {
            return self::responseMsgCode('REGISTER_CODEWRONG');
        }

        $api = new UserAPI();
        $userIndo = UserAPI::getUseridByPhone($param['phone']);
        $param['id'] = $userIndo->id;
        if (decrypt($userIndo->password) == $param['password'])
            return self::responseMsgCode('SAME_PASSWOED');


        if ($api->update($param)) return self::responseMsgCode('OK');


    }
}