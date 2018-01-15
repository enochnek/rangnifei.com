<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 11:14
 */

namespace App\Services\User;

use App\Models\User\Order;
use App\Models\User\User;
use App\models\user\UserFavorite;
use App\models\user\UserProfile;
use App\Services\API;

class UserHandleAPI extends UserAPI
{
    protected $class = User::class;

    public static function createUser($param) {

        $api = new self();
        $resp = $api->create($param);
        if ($resp) {
            $paramProfile['userid'] = $resp->id;
            $paramProfile['avatar'] = env('APP_URL') . '/images/default.jpg';
            API::createModel($paramProfile, UserProfile::class);
        }
        return $resp;
    }

    public static function createOrder($param) {

        $resp = self::createModel($param, Order::class);
        return $resp;
    }

    public static function favoriteItem($userid, $itemid) {

        $resp = self::createModel(['userid'=>$userid, 'itemid'=>$itemid],
            UserFavorite::class);

        return $resp;
    }

    public static function unFavoriteItem($userid, $itemid) {

        $resp = UserFavorite::where('userid', $userid)
            ->where('itemid', $itemid)->delete();

        return $resp;

    }
}