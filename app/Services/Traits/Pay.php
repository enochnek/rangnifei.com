<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 10:15
 */

namespace App\Services\Traits;

trait Pay
{

    private $apiAlipay;
    private $apiWechat;

    function __construct()
    {
        $this->apiAlipay = new PayAPI('alipay');
    }

    public function sychronized($param)
    {

        $resp = $this->apiAlipay->getSychronizedMsg($param);
        return $resp;
    }

    public function aysn($param)
    {

        // Single param parsing
        $backParam = $param['passback_params'];
        $passbackParams = explode("=", urldecode($backParam));
        $param['userid'] = $passbackParams[1];

        // Multi params parsing
        // $passbackParams = explode("&", urldecode($array));
        // $param['itemid'] = explode('=',$passbackParams[0])[1];
        // $param['userid'] = explode('=',$passbackParams[1])[1];

        file_put_contents(storage_path('alipay.json'), "触发回调函数" . DIRECTORY_SEPARATOR, FILE_APPEND);
        file_put_contents(storage_path('alipay.json'), json_encode($param) . DIRECTORY_SEPARATOR, FILE_APPEND);

        $param = Format::removeAttrs($param, ['charset', 'sign', 'notify_type', 'sign_type',
            'version', 'invoice_amount', 'passback_params']);

        $resp = $this->apiAlipay->create($param);
        return 'success';
    }
}