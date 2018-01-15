<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 20:27
 */

namespace App\Services\Config;

use App\Models\Config\AlipayLog;
use Yansongda\Pay\Pay;
use App\Services\API;

class PayAPI extends API
{

    //protected $config;
    //protected $pay;

    protected $payMethod;
    protected $gateway;
    private $classArray = [
        'alipay' => AlipayLog::class,
        'wechat' => null,
    ];

    function __construct($payMethod, $url = null)
    {

        $config[$payMethod] = config('pay.' . $payMethod);

        if ($url) $config[$payMethod]['return_url'] = $url;

        $this->payMethod = $payMethod;
        $pay = new Pay($config);
        // $this->gateway = $pay->driver($payMethod)->gateway('transfer');
        $this->gateway = $pay->driver($payMethod)->gateway();
    }

    // Pay
    public function getPayPage($param)
    {   
        return $this->gateway->pay($param);
    }

    public function getSychronizedMsg($param)
    {

        return $this->gateway->verify($param);
    }

    public function getLog($param)
    {

        return $this->gateway->find($param);
    }

    // Refund
    public function getRefund()
    {
    }

    // System
    public function create($param, $class = null)
    {

        // TODO
        return parent::create($param, $this->classArray[$this->payMethod]);
    }

    public function getPayMethod()
    {
        return $this->payMethod;
    }
}