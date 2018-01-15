<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 11:05
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\UpdateUserProfileRequest;
use App\Repositories\Interfaces\AuthInterface;
use App\Services\User\AuthAPI;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserHandleInterface;
use Illuminate\Support\Facades\Session;
class UserFavoriteController extends BaseController
{	

	private $inter;

    function __construct(UserHandleInterface $inter)
    {
        $this->inter = $inter;
    }
    public function favorite(Request $request) {

        $uid = $request->session()->get('user')->id;
        $isLogin = isset($uid) ?  true : false;

        if(!$isLogin)
            return self::responseMsgCode('NOT_LOGIN');
        $itemid = $request->input('itemid');
        $resp = $this->inter->favoriteItem($uid,$itemid);
        return self::responseMsgCode($resp);
    }
    public function unFavorite(Request $request) {

        $uid = $request->session()->get('user')->id;
        $isLogin = isset($uid) ?  true : false;
        if(!$isLogin)
            return self::responseMsgCode('NOT_LOGIN');

        $itemid = $request->input('itemid');
        $resp = $this->inter->UnFavoriteItem($uid,$itemid);
        return self::responseMsgCode($resp);
    }


}