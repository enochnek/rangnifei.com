<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/9/15
 * Time: 10:18
 */

namespace App\Services\SMS;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;

class SendSMS
{

    public function sendRegisterSMS($phone) {
        return $this->sendMessageCode($phone, config('C.SMS_REGISTER'));
    }

    public function sendResetPasswordSMS($phone) {
        return $this->sendMessageCode($phone, config('C.SMS_RESETPASS'));
    }

    private function sendMessageCode($phone, $type) {
        $config = [
            'app_key' => config('C.SMS_KEY'),
            'app_secret' => config('C.SMS_SECRET'),
            'sandbox' => false
        ];

        $msgcode = rand(100000, 999999);
        $client = new Client(new App($config));
        $req = new AlibabaAliqinFcSmsNumSend;
        $req->setRecNum($phone)
            ->setSmsParam([
                'code' => $msgcode,
                'product' => config('C.PRODUCT_NAME')
            ])
            ->setSmsFreeSignName(config('C.PRODUCT_INC'));
        $req->setSmsTemplateCode($type);
        $client->execute($req);

        return $msgcode;
    }
}