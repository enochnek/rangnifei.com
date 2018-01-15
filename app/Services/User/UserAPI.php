<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 11:14
 */

namespace App\Services\User;

use App\Models\Item\Item;
use App\Models\Item\ItemComment;
use App\Models\User\Order;
use App\Models\User\User;
use App\models\user\UserFavorite;
use App\Services\API;
use Illuminate\Support\Facades\DB;

class UserAPI extends API
{
    protected $class = User::class;

    public static function getOrders($userid, $limit = 10, $offset = 0) {
        return Order::where('order_userid', $userid)->orderBy('created_at', 'desc')
            ->offset($offset)->take($limit)->get();
    }

    public static function getItemOrderIds($itemid, $userid) {
        return Order::where('order_itemid', $itemid)
            ->where('order_userid', $userid)->get(['id']);
    }
    public static  function getCommentCount($itemid, $userid) {
        return ItemComment::where('itemid', $itemid)->where('userid',$userid)->get()->count();
    }
    public static function getItemOptionOrderIds($optionid, $userid) {
        return Order::where('order_optionid', $optionid)
            ->where('order_userid', $userid)->get('id');
    }

    public static function getDynamic($userid) {

        $data['myItemsCount'] = self::getCount('userid', $userid, Item::class);
        $data['myOrdersCount'] = self::getCount('order_userid', $userid, Order::class);
        $data['myUserCount'] = self::getCount('inviterId', $userid, User::class);
        $data['myInvitation'] = DB::table('user_invitation')
			->where('inviterId', $userid)
			->sum('money');
			
        $data['myCostTotal'] = DB::table("order")
            ->where('order_userid', $userid)
            ->sum('order_cost');
        return $data;
    }

    public static function getUseridByPhone($phone) {

        return User::where('phone', $phone)->first();
    }

    public static function getItemIds($userid) {
        return Item::where('userid', $userid)->get(['id']);
    }

    public static function isFavorite($userid, $itemid) {

        return UserFavorite::where('itemid', $itemid)
            ->where('userid', $userid)->get()->count();
    }

    public static function getFavoritesItems($userid, $limit = 10, $offset = 0) {

        return UserFavorite::where('userid', $userid)
            ->offset($offset)->take($limit)
            ->orderBy('created_at', 'desc')
            ->with(['item'])->get();
    }
    public static function getUserBalance($userid) {
        return User::find($userid)->money;
    }

    public function create($param, $class = null) {
        if (isset($param['password'])) {
            $param['password'] = encrypt($param['password']);
        }
        return parent::create($param); // TODO: Change the autogenerated stub
    }
    public function update($param, $class = null, $nonCreate = false) {
        if (isset($param['password'])) {
            $param['password'] = encrypt($param['password']);
        }
        return parent::update($param, $class);
    }
    public static function checkBalance($userid, $payMoney) {
        $balance = self::getUserBalance($userid);
        if ($balance < $payMoney) return false;
        return true;
    }
    public static function balanceConsume($userid, $money) {
        $user = User::find($userid);
        $user->money += $money;
        if ($user->save())
            return $user->money;
        return false;
    }
    public static function addExp($userid, $money) {
        $user = User::find($userid);
        $user->exp += $money;
        if ($user->save())
            return true;
        return false;
    }

}