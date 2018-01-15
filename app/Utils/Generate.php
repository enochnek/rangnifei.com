<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/9/28
 * Time: 20:42
 */

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;

class Generate
{

    public static function makeSecret($md5KeyArray, $extra = null)
    {

        // Md5
        $keyStr = '';
        foreach ($md5KeyArray as $md5Key) {
            $keyStr .= $md5Key;
        }
        $md5Out = md5($keyStr);
        $md5KeyArray['md5Out'] = $md5Out;

        // App
        $appSecret = config('C.APP_SECRET');

        ksort($md5KeyArray);

        $secret = '';
        foreach ($md5KeyArray as $k => $v) {
            $secret .= $k . $v;
        }

        if (isset($extra)) {
            $secret = strtoupper(sha1($appSecret . $secret . $appSecret . $extra));
        } else {
            $secret = strtoupper(sha1($appSecret . $secret . $appSecret));
        }
        return $secret;
    }

    public static function makeNo()
    {
        return date('ymd', time()) . substr(time(), -5) . rand(100, 1000);
    }
}