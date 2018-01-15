<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 11:05
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;

use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Interfaces\AuthInterface;
use App\Services\SMS\SendSMS;
use App\Services\User\AuthAPI;
use App\Services\User\UserHandleAPI;
use App\Utils\Format;
use App\Utils\Lottery;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\User\UserInvitation;

class RegisterController extends BaseController
{
    public function sendRegisterSMS(Request $request)
    {
        $phone = $request->input('phone');

        if ($phone == null) {
            return self::responseMsgCode('REGISTER_PHONETAKEN');
        }

        if (UserHandleAPI::getUseridByPhone($phone) != null) {
            return self::responseMsgCode('REGISTER_PHONETAKEN');
        }

        $sms = new SendSMS();
        $msgcode = $sms->sendRegisterSMS($phone);

        AuthAPI::createTempPhone($phone, $msgcode);

        return self::responseMsgCode('OK');
    }

    public function register(RegisterRequest $request, AuthInterface $inter)
    {

        if (self::hasRequestError($request)) {
            return self::responseRequestError($request);
        }
        $inviterId = $request->input('inviterId');
        $user = User::find($inviterId);
        $invitationFund = $user->invitation_fund;
        $redPacket = new Lottery();
        $redPrice = $redPacket->getPrice();
        if($invitationFund < $redPrice)  $redPrice =  $invitationFund;
        $msgcode = $request->input('msgcode');
        $keys = ['phone', 'username', 'password', 'inviterId','money'];
        $registerParam = $request->all();
        $registerParam['money'] = $redPrice;
        $param = Format::filter($registerParam, $keys);

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

        $createUserResp = UserHandleAPI::createUser($param);

        // 用户可邀请其他人的金额不为0时
        if ($redPrice) {
            $userInvitation = new UserInvitation();
            $userInvitation->userid = $createUserResp->id;
            $userInvitation->inviterId = $inviterId;
            $userInvitation->money = $redPrice;
            $userInvitation->save();
        }

        $resp = $inter->loginByAccount($request, $param);
        $config = config('R.' . $resp);

        if ($config && $config > 0) {
            return self::responseMsgCode($config);
        }
        if ($user) {
             $user->invitation_fund -= $redPrice;
            $user->save();
        }
        $resp['redPacket'] = $redPrice;
       

        return self::responseMsgCode('OK', $resp);
    }
}