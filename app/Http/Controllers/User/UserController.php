<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 11:05
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\Item\Item;
use App\Models\User\Order;
use App\models\user\UserFavorite;
use App\Repositories\Interfaces\UserInterface;
use Illuminate\Http\Request;

class UserController extends BaseController {

    protected $inter;
    function __construct(UserInterface $inter) {

        $this->inter = $inter;
    }

    public function getMyOrders(Request $request) {

        $page = $request->input('page');
        $limit = $request->input('limit');
        $uid = $request->input('uid');

        if (!isset($page) || !$page) $page = 1;

        $data['orders'] = $this->inter->getMyOrders($uid, $limit+1, $limit * ($page - 1));

        if (count($data['orders']) >= $limit+1) {
            $param['page'] = $page;
            $param['next'] = $page + 1;
        } else {
            $param['page'] = $page;
            $param['next'] = $page;
        }
        $count = Order::where('order_userid', $uid)->get()->count();
        $param['total'] = (int) (($count-1)/$limit + 1);
        if ($param['total'] < 1) $param['total'] = 1;
        $param['count'] = $count;
        $data['pager'] = (object) $param;

        unset($data['orders'][$limit]);

        return self::responseMsgCode('OK', $data);
    }
    public function getMyItems(Request $request) {

        $page = $request->input('page');
        $limit = $request->input('limit');
        $uid = $request->input('uid');

        if (!isset($page) || !$page) $page = 1;

        $data['myItems'] = $this->inter->getMyItems($uid, $limit+1, $limit * ($page - 1));

        if (count($data['myItems']) >= $limit+1) {
            $param['page'] = $page;
            $param['next'] = $page + 1;
        } else {
            $param['page'] = $page;
            $param['next'] = $page;
        }
        $count = Item::where('userid', $uid)->get()->count();
        $param['total'] = (int) (($count-1)/$limit + 1);
        if ($param['total'] < 1) $param['total'] = 1;
        $param['count'] = $count;

        $data['pager'] = (object) $param;

        unset($data['myItems'][$limit]);

        return self::responseMsgCode('OK',$data);
    }
    public function getMyFavorites(Request $request) {

        $page = $request->input('page');
        $limit = $request->input('limit');
        $uid = $request->input('uid');

        if (!isset($page) || !$page) $page = 1;

        $data['favorites'] = $this->inter->getMyFavorites($uid, $limit+1, $limit * ($page - 1));

        if (count($data['favorites']) >= $limit+1) {
            $param['page'] = $page;
            $param['next'] = $page + 1;
        } else {
            $param['page'] = $page;
            $param['next'] = $page;
        }

        $count = UserFavorite::where('userid', $uid)->get()->count();
        $param['total'] = (int) (($count-1)/$limit + 1);
        if ($param['total'] < 1) $param['total'] = 1;
        $param['count'] = $count;

        $data['pager'] = (object) $param;

        unset($data['favorites'][$limit]);

        return self::responseMsgCode('OK', $data);

    }
    public function getUserInfo(Request $request) {

        $uid = $request->input('uid');
        $userid = $request->input('userid');

        if ($uid === $userid) {
            $data = $this->inter->getMyUserInfo($uid);
        } else {
            $data = $this->inter->getUserInfo($userid);
        }
        return self::responseMsgCode('OK', $data);
    }
}