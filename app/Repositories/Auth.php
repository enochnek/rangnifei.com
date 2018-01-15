<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 10:46
 */

namespace App\Repositories;

use App\Models\User\User;
use App\Repositories\Interfaces\AuthInterface;
use App\Services\Traits\Cacher\SignCacherList;
use App\Services\User\AuthAPI;
use App\Utils\Generate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class Auth implements AuthInterface
{
    use SignCacherList;

    public static function loginByAccount(Request $request, $param)
    {

        $username = $param['username'];
        $password = $param['password'];

        if (preg_match('/^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\\d{8}$/',
            $username)) {

            $key = 'phone';
        } else if (preg_match('/^(\w)+(\.\w+)*@(\w)+((\.\w{2,3}){1,3})$/',
            $username)) {

            $key = 'email';
        } else {
            $key = 'username';
        }

        $user = User::where($key, $username)->first();

        if (!$user) return 'LOGIN_WRONGPASS';

        if ($password != decrypt($user->password)) {
            return 'LOGIN_WRONGPASS';
        }

        AuthAPI::login($request, $user);
        $data['sign'] = self::sign($user->id, 0);
        $data['userid'] = $user->id;
        return $data;
    }

    public static function checkLogin($userid, $sign)
    {
        $redisSign = self::sign($userid);

        if ($sign && $sign === $redisSign) {

            Redis::set('auth_' . $userid, $sign);
            Redis::expire('auth_' . $userid, 1800);
            return 'OK';
        }

        return 'LOGIN_OUTDATE';
    }

    public static function logout(Request $request)
    {

        AuthAPI::logout($request);
    }
}