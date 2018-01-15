<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 16:22
 */

namespace App\Repositories;

use App\Models\Item\Item;
use App\Models\Item\ItemOption;
use App\Models\Operator\Settle;
use App\Models\User\Consume;
use App\Models\User\User;
use App\models\user\UserFavorite;
use App\Models\User\UserProfile;
use App\Models\User\UserVerification;
use App\Repositories\Interfaces\UserHandleInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Services\Item\ItemAPI;
use App\Services\Traits\Cacher\CounterCacherList;
use App\Services\Traits\Cacher\ItemCacherList;
use App\Services\User\UserAPI;
use App\Services\User\LetterAPI;
use App\Services\User\UserHandleAPI;
use App\Utils\Format;
use App\Utils\Generate;
use Illuminate\Support\Facades\DB;
use App\Services\API;
use App\Utils\SendMail;
use Illuminate\Support\Facades\Redis;

class UserRepository implements UserInterface, UserHandleInterface
{
    use ItemCacherList;
    use CounterCacherList;

    // User
    public function getUserInfo($userid) {

        $user = API::getModel($userid, User::class);
        $profile = $user->profile;

        $user = Format::getAttrs(json_decode($user),
            ['username', 'verification', 'admin', 'status', 'created_at'], true);

        $user->verification_name = DB::table('user_verification_const')
            ->where('id', $user->verification)
            ->first()->verification_name;

        $user->profile = Format::getAttrs(json_decode($profile),
            ['nickname', 'introduction', 'avatar', 'birthday'], true);

        return $user;
    }
    public function getMyUserInfo($userid) {

        $user = API::getModel($userid, User::class);
        $profile = $user->profile;

        $user = Format::removeAttrs(json_decode($user),
            ['password', 'remember_token', 'fake', 'updated_at'], true);


        $verification = DB::table('user_verification_const')
            ->where('id', $user->verification)
            ->first();
        if ($verification) {
            $user->verification_name = $verification->verification_name;
        } else {
            $user->verification_name = config('W.VERIFICATION_NAME_0');
        }

        $user->profile = json_decode($profile);

        $user->dynamic = (object) UserAPI::getDynamic($userid);
        return $user;
    }
    public function updateUserInfo($param, $userid) {

        $paramUser = Format::filter($param, ['phone', 'email',
            'idnumber', 'realname']);

        $api = new UserHandleAPI;
        if ($paramUser) {
            $paramUser['id'] = $userid;
            $resp = $api->update($paramUser);
        }

        $paramProfile = Format::filter($param, ['nickname', 'introduction',
            'avatar', 'birthday', 'address', 'qq', 'wechat', 'bankcard',
            'bankname', 'sex', 'alipay']);

        $profile = UserProfile::where('userid', $userid)->get(['id'])[0];
        $paramProfile['id'] = $profile->id;
        $resp = $api->update($paramProfile, UserProfile::class);

        if ($resp) return $resp;
        return 'ERROR';
    }

    // User's Order
    public function getMyOrders($userid, $limit = 10, $offset = 0) {

        $orders = UserAPI::getOrders($userid, $limit, $offset);
        foreach ($orders as $index => $order) {
            $item = $this->itemInfo($order->order_itemid);
            $option = json_decode($order->option);
            $announcements = json_decode(ItemAPI::getAnnouncements($item->id, 1, 0, [0, 1]));

            $orders[$index] = json_decode($order);
            $orders[$index]->item = Format::getAttrs($item,
                ['id', 'item_title', 'item_weburl', 'item_coverurl'], true);

            $orders[$index]->option = Format::getAttrs($option,
                ['id', 'item_option_title', 'item_option_cost'], true);

            if (isset($announcements[0])) {
                $orders[$index]->announcement = Format::getAttrs($announcements[0],
                    ['id', 'item_anno_content', 'created_at'], true);
            } else {
                $orders[$index]->announcement =
                    (object) ['id' => null, 'item_anno_content' => null, 'created_at' => null];
            }

            $orders[$index]->user = Format::getAttrs($item->user,
                ['id', 'username', 'verification'], true);
        }
        return json_decode($orders);
    }
    // User's Item
    public function getMyItems($userid, $limit = 10, $offset = 0) {

        $itemids = json_decode(ItemAPI::getUserItemids($userid, $limit, $offset));
        $items = null;
        foreach ($itemids as $index => $itemid) {

            $itemid = $itemid->id;
            $item = $this->itemInfo($itemid);
            $item = Format::getAttrs($item, ['id', 'userid', 'item_description',
                'item_status', 'item_cataid', 'item_title', 'item_coverurl',
                'game', 'created_at', 'ended_at'], true);

            $item->dynamic = $this->itemDynamic($itemid);
            $item->item_cata_name = config('W.ITEM_CATAID_' . $item->item_cataid);
            $item->item_status_name = config('W.ITEM_STATUS_' . $item->item_status);

            $item->next_settle_date = $this->getSettleDate($item->id);

            $items[$index] = $item;
            $announcements = json_decode(ItemAPI::getAnnouncements($itemid, 1, 0, [0, 1]));
            if (isset($announcements[0])) {
                $item->announcement = Format::getAttrs($announcements[0],
                    ['id', 'item_anno_content', 'created_at'], true);
            } else {
                $item->announcement =
                    (object) ['id' => null, 'item_anno_content' => null, 'created_at' => null];
            }
        }

        return $items;
    }
    public function createOrder($param, $userid, $status = 0) {

        $optionid = $param['order_optionid'];

        if (!$optionid) {

            $param['order_optionid'] = 0;
            $param['order_serial'] = 0;
        } else {

            $param['order_itemid'] = ItemAPI::getModel($optionid, ItemOption::class)->itemid;
            $param['order_serial'] = $this->serial('optionid_serial', $optionid, 1);
        }

        $param = Format::filter($param, ['order_itemid', 'order_optionid',
            'order_amount', 'order_cost', 'order_note', 'order_serial']);

        $param['order_userid'] = $userid;
        $param['order_status'] = $status;
        $param['order_number'] = Generate::makeNo();
        $resp = UserHandleAPI::createOrder($param);
        $settleData = $this->getSettleDate($param['order_itemid']);
        $resp->order_settle_date = $settleData;
        $newResp = $resp->save();

        // Create Letter and reset redis cache and add integral grade
        if ($newResp) {
            //$content = $this->letterContent($param['order_itemid'],$param['order_optionid'],
            //   $param['order_amount'],$param['order_cost']);
            //$letterParam = ["title"=>"赞助项目成功...","content"=> $content];

           // $this->createNotice($letterParam,$userid);


            Redis::hdel('item_rank', $param['order_itemid']);
            Redis::hdel('items_dynamic', $param['order_itemid']);
            
            UserAPI::addExp($userid,$param['order_cost']);
            return $resp;
        }
        return 'ERROR';
    }

    public function getSettleDate($itemid) {
        $item = API::getModel($itemid, Item::class);
        $intervalTime = $item->item_interval * 86400;
        $currentTime = time();
        $settle = Settle::where('settle_itemid',$itemid)->orderBy('created_at','desc')->first();

        if ($settle) {
            $endTime = strtotime($settle->settle_date);
        }else {
            $endTime = strtotime($item->created_at);
        }

        if (!$intervalTime) $intervalTime = 86400;

        $endTime += $intervalTime;
        while ($currentTime > $endTime) {
            $endTime += $intervalTime;
        }

        return date('Y-m-d H:i:s',$endTime);
    }
    public function letterContent ($itemid, $optionid, $amount, $cost) {

        $item = API::getModel($itemid,Item::class);
        if ($optionid) {
            $optionTitle = API::getModel($optionid,ItemOption::class)->item_option_title;
        } else {
            $optionTitle = "直接赞助";
        }
        $content = "项目 " . $item->item_title . " " .
            $optionTitle . " x " . $amount .
            "。 总价:" . $cost . "。 赞助成功...";
        return $content;
    }


    // User's Favorites
    public function getMyFavorites($userid, $limit = 10, $offset = 0) {
        $favorites = UserAPI::getFavoritesItems($userid, $limit, $offset);

        $data = null;
        foreach($favorites as $index => $favorite) {
            $item = $favorite->item;
            $user = $item->user;

            $data[$index] = Format::getAttrs(json_decode($item), ['id', 'item_title',
                'item_status', 'item_coverurl'], 1);
            $data[$index]->item_status_name =  config('W.ITEM_STATUS_' . $item->item_status);
            $data[$index]->user = Format::getAttrs(json_decode($user),
                ['id', 'username', 'verification'], 1);

            $verification = DB::table('user_verification_const')
                ->where('id', $user->verification)
                ->first();

            if ($verification) {
                $data[$index]->user->verification_name =
                    $verification->verification_name;
            } else {
                $data[$index]->user->verification_name =
                    config('W.VERIFICATION_NAME_0');
            }

        }
        return $data;
    }
    public function favoriteItem($userid, $itemid) {

        $resp = UserAPI::createModel(['userid' => $userid, 'itemid' => $itemid],
            UserFavorite::class);

        if($resp) return 'OK';
        return 'ERROR';
    }
    public function unFavoriteItem($userid, $itemid) {

        $resp = UserFavorite::where('userid',$userid)
            ->where('itemid',$itemid)->delete();

        if($resp) return 'OK';
        return 'ERROR';
    }

    // Verification
    public function createVertification($param, $userid) {

        $param['userid'] = $userid;
        $param = Format::filter($param, ['userid',
            'verification','radio_url','back_img',
            'front_img']);

        $resp = API::createModel($param, UserVerification::class);
        if ($resp) return 'OK';
        return 'ERROR';
    }
    public function successVertification($id) {

        $param['id'] = $id;
        $param['status'] = config("W.VERIFICATION_SUCCESS");

        $api = new API;
        $resp = $api->update($param, UserVerification::class);
        if($resp) {
            $userParam = Format::getAttrs(json_decode($resp), ['verification','realname','idnumber']);
            $userParam['id'] = $resp->userid;
            $api = new UserAPI();
            $api->update($userParam);
        }
        return 'OK';
    }
    public function failVertification($id) {
        $api = new API();
        $resp = $api->delete($id, UserVerification::class);
        return 'OK';
    }

    // Notice
    public function createNotice($param,  $targetUserid, $noticeType = 0, $sourceUserid = 0) {
        $param['target_userid'] = $targetUserid;
        $param['sourceUserid'] = $sourceUserid;
        $param = Format::filter($param, ['source_userid','target_userid',
            'title','content']);
        $resp = LetterAPI::createLetter($param);
        if($noticeType) {
            $user = API::getModel($targetUserid,User::class);
            if(!($user->email == '')) {
                SendMail::send('test',['username' => $user->username,"content" => $param['content']],$user->email,$param['title']);
            }

        }

        if($noticeType && ($noticeType == 2)) {
            // 执行发送短信请求
        }
        if ($resp) return 'OK';
    }

    // Balance
    public function balancePay($title, $userid, $money, $type = 1) {
        $balance = UserAPI::balanceConsume($userid, -$money);
        if ($balance) {
            $param['userid'] = $userid;
            $param['title'] = $title;
            $param['consume'] = $money;
            $param['balance'] = $balance;
            $param['type'] = $type;
            $consumeLog = API::createModel($param,Consume::class);
            if ($consumeLog) return 'OK';
            return 'ERROR';
        }
        return 'ERROR';


    }
}