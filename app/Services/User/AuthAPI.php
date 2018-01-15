<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 11:14
 */

namespace App\Services\User;

use App\models\user\TempPhone;
use App\models\user\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class AuthAPI
{
    public static function createTempPhone($phone, $msgcode, $type = 0) {
        if (!($tempPhone = AuthAPI::getByPhone($phone))) {
            $tempPhone = new TempPhone();
        }

        $tempPhone->phone = $phone;
        $tempPhone->msgcode = $msgcode;
        $tempPhone->type = $type;
        return $tempPhone->save();
    }

    public static function getByPhone($phone, $type = 0) {
        return TempPhone::where('phone', $phone)->where('type', $type)->first();
    }

    public static function login(Request $request, User $user) {
        $password = $request->input('password');

        $expire = Carbon::now()->addHour(6);
        $token = Hash::make($user . $password . $expire);
        $data['remember_token'] = $token;
        User::find($user->id)->update($data);
        //Cache::put($token, $user->toJson(), $expire);

        // Session Store
        $request->session()->put('user', $user);

        return 'OK';
    }

    public static function logout(Request $request) {

        $userid = $request->session()->get('user')->id;

        Redis::del('auth_' . $userid);
        $request->session()->remove('user');

        return 'OK';
    }
}