<?php

namespace App\Http\Controllers\PageWeb;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Requests\Auth\UpdateUserProfileRequest;
use App\Http\Requests\Item\ItemUpdateRequest;
use App\Models\Item\Item;
use App\Models\User\User;
use App\models\user\UserLetter;
use App\models\user\UserVerification;
use App\Repositories\Interfaces\ItemHandleInterface;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\Interfaces\UserHandleInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Services\API;
use App\Services\Item\ItemAPI;
use App\Services\Traits\Cacher\ItemCacherList;
use App\Services\User\LetterAPI;
use App\Services\User\UserAPI;
use App\Utils\Format;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Mockery\Matcher\Closure;

class BackendController extends BaseController {

    protected $inter;
    protected $apiCon;
    function __construct(UserHandleInterface $inter) {

        $this->inter = $inter;
        $this->apiCon = new UserController($inter);
    }

    public function index(Request $request) {

        $param['uid'] = $request->session()->get('user')->id;
        $param['userid'] = $param['uid'];
        $data = $this->apiCon->getUserInfo(self::newRequest($request, $param));
        $viewData['letter'] = UserLetter::where('target_userid',$param['uid'])->where('is_read',0 )->get()->count();
        $viewData['userInfo'] = $data['data'];
      
//        dd($viewData);exit;
        return view('backend', $viewData);
    }

    public function orders(Request $request) {
        $param = $request->all();
        $param['uid'] = $request->session()->get('user')->id;
        $param['limit'] = 5;
        $data = $this->apiCon->getMyOrders(self::newRequest($request, $param));
//        dd($data);
        return Response::view('backend.orders', $data['data']);
    }

    public function myItems(Request $request) {
        $param = $request->all();
        $param['uid'] = $request->session()->get('user')->id;
        $param['limit'] = 5;
        $data = $this->apiCon->getMyItems(self::newRequest($request, $param));
//        dd($data);
        return Response::view('backend.items', $data['data']);
    }

    public function messages(Request $request) {

        $uid = $request->session()->get('user')->id;
        $limit = $request->input('limit');
        $page = $request->input('page');
        $limit  = $limit ? $limit : 10;
        $page  = $page ? $page : 1;
        $offset = $limit * ($page - 1);
        $data['letters'] = LetterAPI::getLetter($uid, $limit, $offset);
        $count = UserLetter::where('target_userid',$uid)->where('is_read',0 )->get()->count();

        $allCount = UserLetter::where('target_userid', $uid)->get()->count();
        $data['pager']['total'] = (int) (($allCount-1)/$limit + 1);
        $data['pager']['page'] = $page;
        $data['pager'] = (object) $data['pager'];

        if ($count) {
            LetterAPI::flagRead($uid);
        }
        //dd($data);
        return view('backend.messages', $data);
    }

    public function verify(Request $request) {

        $userid = $request->session()->get("user")->id;
        $data['verify'] = UserVerification::where('userid',$userid)->first();
        if (!$data['verify']) {
            $data['verify']['status'] = -1;
            $data['verify'] = (object)($data['verify']);
        }
        return view('backend.verify',$data);
    }

    public function favorites(Request $request) {

        $param = $request->all();
        $param['uid'] = $request->session()->get('user')->id;
        $param['limit'] = 5;
        $data = $this->apiCon->getMyFavorites(self::newRequest($request, $param));

        return Response::view('backend.favorites', $data['data']);
    }

    public function publish(Request $request) {

        $count = count(UserAPI::getItemIds($request->session()->get('user')->id));
        if ($count > 10) return redirect('/backend/orders');

        return view('publish');
        }

    public function profile(Request $request) {

        $userid = $request->session()->get("user")->id;
        $user = User::find($userid);
        $data['user'] = $user;
        $verify = UserVerification::where("status",1)->where('userid',$userid)->first();
        if ($verify) $data['verify'] = $verify->verification;
        else $data['verify'] = 0;
        return view('backend.profile',$data);
    }

    public function uploadAvatar() {

        return view('backend.uploadavatar');
    }

    public function edit(Request $request, $itemid, ItemInterface $itemInter) {

        $uid = $request->session()->get('user')->id;
        $is = self::isBelongs($uid, 'userid', $itemid, Item::class);
        if (!$is) return redirect('/');

        $item = $itemInter->getcItemInfo($itemid);
        $data['item'] = Format::removeAttrs($item, ['announcements', 'dynamic', 'user',
            'item_fund', 'item_interval', 'item_fake', 'item_priority', 'item_ribbon'], true);

        $options = $data['item']->options;
        $data['item']->options = array_values((array)$options);
        return view('edit', $data);
    }

    public function announcements(Request $request, ItemHandleInterface $inter) {

        $apiCon = new ItemController($inter);

        $request->offsetSet('limit', 9999);
        $request->offsetSet('offset', 0);
        $request->offsetSet('private', 1);
        $request->offsetSet('uid', $request->session()->get('user')->id);
        $data = $apiCon->getAnnouncements($request);
        $data['data']['itemid'] = $request->input('itemid');

        return view('backend.announce', $data['data']);
    }

    public function sponsors(Request $request, ItemHandleInterface $inter) {

        $request->offsetSet('uid', $request->session()->get('user')->id);
        $optionid = $request->input('optionid');
        isset($optionid) ? $request->offsetSet('optionid', $optionid) : -1;
        $apiCon = new ItemController($inter);

        $data = $apiCon->sponsorsList($request);
        if ($data == 'ERROR') return redirect('/');
        return view('backend.splist',$data);
    }

    public function settles(Request $request, ItemHandleInterface $inter) {
        $request->offsetSet('uid', $request->session()->get('user')->id);
        $apiCon = new ItemController($inter);
        $data = $apiCon->settlesList($request);
        if ($data == 'ERROR') return redirect('/');
        return view('backend.settlehistory',$data);
    }

    public function downLoadPartakeInfo(Request $request, $itemid,  ItemHandleInterface $itemInter) {

        $request->offsetSet('uid', $request->session()->get('user')->id);
        $request->offsetSet('itemid', $itemid);
        $apiCon = new ItemController($itemInter);
        $resp = $apiCon->downLoadPartakeInfo($request);
        if (self::isErrorMsg($resp)) return self::responseMsgCode($resp);
        return $resp;

    }

    public function showItemStatus(Request $request) {
        $itemid = $request->input('itemid');
        $currentStatus = ItemAPI::getItemStatas($itemid);
        $currentStatus = config('W.ITEM_STATUS_' . $currentStatus);
        return view('backend.changestatus',["currentStatus" => $currentStatus,"itemid"=>$itemid]);
    }
}
