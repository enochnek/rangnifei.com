<?php

namespace App\Http\Controllers\PageWeb;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Requests\Auth\UpdateUserProfileRequest;
use App\Http\Requests\Item\ItemCreateRequest;
use App\Http\Requests\Item\ItemUpdateRequest;
use App\Models\Item\Item;
use App\Models\User\User;
use App\Repositories\Interfaces\ItemHandleInterface;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\Interfaces\UserHandleInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Services\API;
use App\Services\Traits\Cacher\ItemCacherList;
use App\Utils\Format;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Mockery\Matcher\Closure;

class BackendDataController extends BaseController
{
    protected $inter;
    protected $apiCon;
    function __construct(UserHandleInterface $inter) {

        $this->inter = $inter;
        $this->apiCon = new UserController($inter);
    }

    public function createItem(ItemCreateRequest $request, ItemHandleInterface $itemInter) {

        if (self::hasRequestError($request)) {
            return self::responseRequestError($request);
        }

        $uid = $request->session()->get('user')->id;
        $resp = $itemInter->createItem($request->all(), $uid);

        if (self::isErrorMsg($resp)) return self::responseMsgCode($resp);

        return self::responseMsgCode('OK');
    }
    public function updateItem(ItemUpdateRequest $request, ItemHandleInterface $newInter) {

        if (self::hasRequestError($request)) {
            return self::responseRequestError($request);
        }

        $request->offsetSet('uid', $request->session()->get('user')->id);

        $apiCon = new ItemController($newInter);

        $resp = $apiCon->update($request);

        if (self::isErrorMsg($resp)) return self::responseMsgCode($resp);
        return self::responseMsgCode('OK');
    }
    public function endItem(Request $request, ItemHandleInterface $newInter) {
        $request->offsetSet('uid', $request->session()->get('user')->id);

        $apiCon = new ItemController($newInter);

        $resp = $apiCon->endItem($request);

        if (self::isErrorMsg($resp)) return self::responseMsgCode($resp);
        return self::responseMsgCode('OK');
    }
    public function getAnnouncements(Request $request, ItemHandleInterface $newInter) {

        $request->offsetSet('uid', $request->session()->get('user')->id);

        $apiCon = new ItemController($newInter);

        $resp = $apiCon->getAnnouncements($request);

        if (self::isErrorMsg($resp)) return self::responseMsgCode($resp);
        return $resp;
    }
    public function createAnnouncement(Request $request, ItemHandleInterface $newInter) {

        $request->offsetSet('uid', $request->session()->get('user')->id);

        $apiCon = new ItemController($newInter);

        $resp = $apiCon->createAnnouncement($request);

        if (self::isErrorMsg($resp)) return self::responseMsgCode($resp);
        return $resp;
    }
    public function createComment(Request $request, ItemHandleInterface $newInter) {


        $request->offsetSet('uid', $request->session()->get('user')->id);

        $apiCon = new ItemController($newInter);

        $resp = $apiCon->createComment($request);

        if (self::isErrorMsg($resp)) return self::responseMsgCode($resp);
        return $resp;
    }
    public function updateProfile(UpdateUserProfileRequest $request) {

        if (self::hasRequestError($request)) {
            return self::responseRequestError($request);
        }
        $uid = $request->session()->get('user')->id;
        $request->offsetSet('uid', $uid);

        $apiCon = new UserProfileController($this->inter);

        $resp = $apiCon->updateProfile($request);

        if (self::isErrorMsg($resp)) return self::responseMsgCode($resp);

        $user = User::find($uid);
        $request->session()->remove('user');
        $request->session()->put('user', $user);

        return self::responseMsgCode('OK');
    }
}
