<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 11:05
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Repositories\Interfaces\AuthInterface;
use App\Services\User\AuthAPI;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    public function login(Request $request, AuthInterface $inter) {

        $resp = $inter->loginByAccount($request, $request->all());

        $config = config('R.' . $resp);

        if ($config && $config > 0) {
            return self::responseMsgCode($resp);
        }

        return self::responseMsgCode('OK', $resp);
    }

    public function logout(Request $request) {


        $resp = AuthAPI::logout($request);
        
        return self::responseMsgCode('OK', $resp);
    }

    public function checkLogin(Request $request, AuthInterface $inter) {

        $userid = $request->input('userid');
        $sign = $request->input('sign');
        $resp = $inter->checkLogin($userid, $sign);
        return self::responseMsgCode( $resp);
    }
}