<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/9/28
 * Time: 20:42
 */

namespace App\Services\Traits\Cacher;

use App\Utils\Generate;
use Illuminate\Support\Facades\Redis;

trait SignCacherList
{

    public static function sign($userid, $readOnly = 1) {

        if (!($sign = Redis::get('auth_' . $userid))) {

            if ($readOnly) {
                return 0;
            } else {
                $sign = Generate::makeSecret(['userid' => $userid]);
                Redis::set('auth_' . $userid, $sign);
                Redis::expire('auth_' . $userid, 1800);
            }
        }
        return $sign;
    }
}