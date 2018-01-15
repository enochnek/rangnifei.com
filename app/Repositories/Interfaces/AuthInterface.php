<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 10:18
 */

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface AuthInterface
{
    public static function loginByAccount(Request $request, $param);

    public static function logout(Request $request);

    public static function checkLogin($userid, $sign);
}