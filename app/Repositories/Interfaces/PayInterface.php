<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 10:18
 */

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface PayInterface
{
    public function set($url = null, $method = 'alipay');

    public function alipay($param, $extra);
    
    public function transfer($param);

    public function sychronized($param);

    public function asyn($param);
}