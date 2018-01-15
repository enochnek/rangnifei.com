<?php

namespace App\Http\Controllers\Config;


use App\Http\Controllers\BaseController;
use App\Utils\Config\AliOSS;

class WebConfigController extends BaseController
{
    public function getOssSign()
    {

        $param = array(
            'id' => config('C.OSS_ACCESSKEYID'),
            'key' => config('C.OSS_ACCESSKEYSECRET'),
            'host' => config('C.OSS_URL'),
            'expire' => config('C.OSS_EXPIRE'),
            'dir' => config('C.OSS_UPLOAD_ITEM')
        );
        $json = new AliOSS($param);
        echo $json->returnResponse();
    }
}
