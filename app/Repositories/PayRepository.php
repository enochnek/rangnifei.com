<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 10:46
 */

namespace App\Repositories;

use App\Repositories\Interfaces\OrderSaveInterface;
use App\Repositories\Interfaces\PayInterface;
use App\Repositories\Interfaces\UserHandleInterface;
use App\Services\Traits\Cacher\CounterCacherList;
use App\Utils\Format;
use Illuminate\Http\Request;
use App\Services\Config\PayAPI;

class PayRepository implements PayInterface
{
    private $apiAlipay;
    private $apiWechat;
    private $inter;

    use CounterCacherList;

    function __construct(UserHandleInterface $inter) {

        $this->inter = $inter;
        $this->apiAlipay = new PayAPI('alipay');
    }

    public function set($url = null, $method = 'alipay') {
        $this->apiAlipay = new PayAPI($method, $url);
        return $this;
    }

    // http://esfeng2.dev/alipay?total_amount=0.01&subject=testAlipay&body=英雄联盟点卷&timeout_express=1c&goods_type=0&userid=xxx
    public function alipay($param, $extra) {

        $param['out_trade_no'] = date('ymd', time()) . substr(time(), -5) . rand(100, 1000);
        $param['passback_params'] = $extra;
        return $this->apiAlipay->getPayPage($param);
    }
    public function transfer($param) {
        
        $config_biz = [
            'out_biz_no' => date('ymd', time()) . substr(time(), -5) . rand(100, 1000),
            /**
             * 收款方账户类型。可取值： 
                1、ALIPAY_USERID：支付宝账号对应的支付宝唯一用户号。以2088开头的16位纯数字组成。 
                2、ALIPAY_LOGONID：支付宝登录号，支持邮箱和手机号格式。
             */
            'payee_type' => 'ALIPAY_LOGONID',       
            'payee_account' => '13330295142',   // 收款方账户
            'amount' => '0.1',                        // 转账金额
            'payer_show_name' => '尊敬的esfeng用户',             // 付款方姓名
            'payee_real_name' => '刘强',             // 收款方真实姓名 这里必须是真实姓名
            'remark' => '来自成都夕岛科技有限公司的转账',                      // 转账备注
        ];
        
        return $this->apiAlipay->getPayPage($config_biz);
    }

    public function wechat($param) {

    }

    public function sychronized($param) {

        $resp = $this->apiAlipay->getSychronizedMsg($param);
        return $resp;
    }

    public function asyn($param) {

        file_put_contents(storage_path('alipay.json'), json_encode($param) . "\r\n", FILE_APPEND);

        // Single param parsing
        $backParam = $param['passback_params'];
        $passbackParams = explode('&', urldecode($backParam));
        foreach ($passbackParams as $key => $value) {
            $temp = explode("=", urldecode($value));
            $param[$temp[0]] = $temp[1];
        }
        $alipayParam = Format::getAttrs($param, ['trade_no', 'out_trade_no', 'total_amount',
            'subject', 'buyer_id', 'body', 'notify_id', 'fund_bill_list', 'trade_status', 'auth_app_id'
            , 'receipt_amount', 'point_amount', 'app_id', 'buyer_pay_amount', 'seller_id', 'gmt_create', 'gmt_payment',
            'notify_time']);
        $alipayParam['userid'] = $param['order_userid'];
        $resp = $this->apiAlipay->create($alipayParam);
        if (!$param['top']) {

            $userid = $param['order_userid'];
            $orderParam = Format::getAttrs($param, ['order_itemid',
                'order_optionid', 'order_amount', "order_note"]);
            $orderParam['order_cost'] = $alipayParam['total_amount'];
            $this->inter->createOrder($orderParam, $userid, 1);
        }
        return 'success';
    }

    public function getPayment(Request $request) {

    }
}