<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 11:05
 */

namespace App\Http\Controllers;

use App\Console\Commands\SettleGenerator;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\User\UserController;
use App\Models\Item\Item;
use App\Models\Item\ItemOption;
use App\Models\User\Order;
use App\models\user\UserProfile;
use App\Repositories\Interfaces\ItemHandleInterface;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\Interfaces\UserHandleInterface;
use App\Repositories\Interfaces\PayInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\ItemRepository;
use App\Repositories\UserRepository;
use App\Services\API;
use App\Services\Config\PayAPI;
use App\Services\Item\ItemAPI;
use App\Services\Item\ItemHandleAPI;
use App\Services\Traits\Cacher\CounterCacherList;
use App\Services\Traits\Cacher\ItemCacherList;
use App\Services\User\LetterAPI;
use App\Services\User\UserAPI;
use App\Utils\ConstGetter;
use App\Utils\Format;
use App\Utils\OutputFile;
use App\Utils\SendMail;
use Faker\Provider\bn_BD\Utils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Predis\Client;

class testController extends BaseController
{
    private $inter;
    use ItemCacherList;
    use CounterCacherList;

    function __construct(PayInterface $inter)
    {
        $this->inter = $inter;
    }

    public function test(Request $request, UserHandleInterface $newInter) {
//        $newInter->createOrder([],1);
        $s = new SettleGenerator;
        dd($s->handle());

        $array = [
            ['itemid' => 1, 'cost' => 10, 'amount' => 1],
            ['itemid' => 1, 'cost' => 10, 'amount' => 2],
            ['itemid' => 1, 'cost' => 22, 'amount' => 2],
            ['itemid' => 2, 'cost' => 5, 'amount' => 2],
            ['itemid' => 2, 'cost' => 55, 'amount' => 1],
            ['itemid' => 3, 'cost' => 1, 'amount' => 5],
            ['itemid' => 3, 'cost' => 3, 'amount' => 5],
            ['itemid' => 4, 'cost' => 10, 'amount' => 1],
        ];


        $field = [
            'itemid' => function($itemid) {
                return $itemid;
            }
        ];

        $field_value = [
            'itemid' => function($itemid) {
                    return $itemid[0]['itemid'];
            },

            'cost' => function($cost) {
                $cost = array_sum(array_column($cost, 'cost'));
                return $cost;
            }
        ];

        $data = \App\Utils\ArrayGroupBy::groupBy($array, $field, $field_value);
        dd($data);






    }

    public function test2(Request $request, UserHandleInterface $inter)
    {   

        // $name = '刘强';
        // // Mail::send()的返回值为空，所以可以其他方法进行判断
        // $to = '1090035743@qq.com';
        // $subject = "Rangnifeng.com";
        // $content = "你好这是一封测试邮件";
        // Mail::send('test',['name' => $name,"content" => $content],function($message) use ($to, $subject) {
        //     $message ->to($to)->subject($subject);
        // });
        // // 返回的一个错误数组，利用此可以判断是否发送成功
        // dd(Mail::failures());
        $param = ["title"=>"付款到账通知","content"=>"你支付的英雄联盟赞助赛项目赞助成功"];
        if($inter->createNotice($param,1))
            return 'OK';
    }

    public function test3(Request $request, UserHandleInterface $inter) {

        $data = $inter->getUserInfo(999);
        dd($data);exit;
    }

    public function test4(Request $request)
    {
        return view('success');
    }
    public function test5 (Request $request) {

    }

}