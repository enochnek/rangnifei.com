<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/9/28
 * Time: 20:42
 */

namespace App\Services\Traits\Cacher;

use App\Utils\Format;
use Illuminate\Support\Facades\Redis;

trait CounterCacherList
{

    public function serial($key, $value, $offset = 0) {

        if ($offset == 0) {
            $serial = intval(Redis::hget($key, $value));
        } else {
            $serial = Redis::hincrby($key, $value, $offset);
        }
        return $serial;
    }
}