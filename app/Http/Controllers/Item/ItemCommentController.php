<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 18:30
 */

namespace App\Http\Controllers\Item;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Item\CommentCreateRequest;
use App\Http\Requests\Item\ItemCreateRequest;
use App\Http\Requests\Item\ItemUpdateRequest;
use App\Models\Item\Item;
use App\Models\User\Order;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\Interfaces\ItemHandleInterface;
use App\Services\Item\ItemAPI;
use App\Services\User\UserAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\Traits\Cacher\ConductionCacherList;
use App\Utils\OutputFile;
class ItemCommentController extends BaseController
{

    use ConductionCacherList;

    protected $inter;
    function __construct(ItemHandleInterface $inter) {
        $this->inter = $inter;
    }
    public function createComment(CommentCreateRequest $request) {

        $uid = $request->input('uid');
        $parent = $request->input('parent');
        $itemid = $request->input('itemid');


        $count = UserAPI::getItemOrderIds($itemid, $uid)->count();
	
        $is = self::isBelongs($uid, 'userid', $itemid, Item::class);
		
        if (!$count && !$is )  return 'COMMENT_NOT_PAY';

        if ($parent == 0 && UserAPI::getCommentCount($itemid, $uid) == 5)  return 'COMMENT_LIMIT';

        $resp = $this->inter->createComment($request->all(), $uid);
        if (self::isErrorMsg($resp)) return self::responseMsgCode($resp);

        return 'OK';
    }
}