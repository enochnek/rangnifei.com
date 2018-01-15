<?php

namespace App\Http\Controllers\PageWeb;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Item\ItemCommentController;
use App\Http\Requests\Item\CommentCreateRequest;
use App\Http\Requests\User\PayRequest;
use App\Models\Item\ItemComment;
use App\Models\Item\ItemOption;
use App\Repositories\Interfaces\ItemHandleInterface;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\Interfaces\PayInterface;
use App\Repositories\Interfaces\UserHandleInterface;
use App\Services\API;
use App\Services\Item\ItemAPI;
use App\Services\Item\ItemHandleAPI;
use App\Services\User\UserAPI;
use App\Services\User\UserHandleAPI;
use App\Utils\Format;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;

class InfoDataController extends BaseController
{
    private $inter;

    function __construct(UserHandleInterface $inter) {
        $this->inter = $inter;
    }

    public function fav(Request $request, $itemid) {

        $uid = $request->session()->get('user')->id;

        //$resp = $this->inter->favoriteItem($uid, $itemid);
        $resp = UserHandleAPI::favoriteItem($uid, $itemid);

        return self::responseMsgCode('OK');
    }

    public function unfav(Request $request, $itemid) {

        $uid = $request->session()->get('user')->id;

        //$resp = $this->inter->favoriteItem($uid, $itemid);
        $resp = UserHandleAPI::unFavoriteItem($uid, $itemid);

        return self::responseMsgCode('OK');
    }

    public function createComment(CommentCreateRequest $request, $itemid, ItemHandleInterface $newInter) {

        $geetest = $this->validate($request, [
            'geetest_challenge' => 'geetest',
        ], [
            'geetest' => config('geetest.server_fail_alert')
        ]);
        if(!count($geetest)) return self::responseMsgCode('GEETEST_ERROR');

        $uid = $request->session()->get('user')->id;

        $apiCon = new ItemCommentController($newInter);


        $request->offsetSet('uid', $uid);
        $request->offsetSet('itemid', $itemid);

        $resp = $apiCon->createComment($request);
        if (self::isErrorMsg($resp)) return self::responseMsgCode($resp);

        return self::responseMsgCode('OK');
    }
}
