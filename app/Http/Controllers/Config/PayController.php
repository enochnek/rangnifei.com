<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/20
 * Time: 13:45
 */

namespace App\Http\Controllers\Config;

use App\Repositories\Interfaces\PayInterface;
use App\Services\Config\PayAPI;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class PayController extends BaseController
{

    protected $inter;

    function __construct(PayInterface $inter)
    {
        $this->inter = $inter;
    }

    // Alipay Sychronized Callback (Get)
    public function sychronizedSuccess(Request $request)
    {
        $data = $this->inter->sychronized($request->all());

    }

    // Alipay Aysn Callback (Post)
    public function asynSuccess(Request $request)
    {
//        $param = '{"gmt_create":"2017-11-20 16:00:23","charset":"utf-8","subject":"Esfeng - \u8d5e\u52a9 0.1 \u5143","sign":"Pylk0TJ7U7qOptHWlBd1ZWBzSHzyURQdChwQGXWRNVXZ3AtdjCPlWWg\/SBHOS3C8IDoE4jTK+mBiRFTqfanPLWLI\/yGupXhoyidixh6CXki55g0yCMtpQmy4PYc3yXBGx+oAHHwQpddUObPwQEaGZDRJGYjB0kioJbE9gNjN1XTJePB2OxhXFzlrG4c2cZ9EWJWO369UaEGrOmwsI+5p1fw4OIQ7eJp09dtJxihNCIfliAVt+vB5dJvYMIiUyUZPgtr72A98amiZ1e07BXyDFRUiGA+xxshPve0cx08OouZulGbjEPTXwzRHj+HKHU6R9Xa80FYr+tTvHOrFZMdVbA==","buyer_id":"2088612138256442","body":"(1\u4e2a) \u76f4\u63a5\u8d5e\u52a9","invoice_amount":"0.10","notify_id":"ca3a9cbaeaca48b5a2d73d34e0d1bb4jea","fund_bill_list":"[{\"amount\":\"0.10\",\"fundChannel\":\"ALIPAYACCOUNT\"}]","notify_type":"trade_status_sync","trade_status":"TRADE_SUCCESS","receipt_amount":"0.10","app_id":"2016080301700751","buyer_pay_amount":"0.10","sign_type":"RSA2","seller_id":"2088421439651052","gmt_payment":"2017-11-20 16:00:31","notify_time":"2017-11-20 16:00:31","passback_params":"order_userid%3D1%26order_itemid%3D1%26order_optionid%3D0%26order_amount%3D1%26order_cost%3D0.1%26order_status%3D2%26top%3D0","version":"1.0","out_trade_no":"17112064822767","total_amount":"0.10","trade_no":"2017112021001104440245679768","auth_app_id":"2016080301700751","point_amount":"0.00"}';
//        return $this->inter->asyn(json_decode($param,true));
        return $this->inter->asyn($request->all());
    }

}