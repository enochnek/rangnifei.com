<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 18:30
 */

namespace App\Http\Controllers\Item;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Item\ItemCreateRequest;
use App\Http\Requests\Item\ItemUpdateRequest;
use App\Models\Item\Item;
use App\Models\Item\ItemAnnouncement;
use App\Repositories\Interfaces\ItemHandleInterface;
use App\Services\Item\ItemAPI;
use App\Services\User\UserAPI;
use App\Utils\Format;
use Illuminate\Http\Request;
use App\Services\Traits\Cacher\ConductionCacherList;
use App\Utils\OutputFile;
class ItemController extends BaseController
{

    use ConductionCacherList;

    protected $inter;
    function __construct(ItemHandleInterface $inter) {
        $this->inter = $inter;
    }

    // Items
    public function getOrderedItems(Request $request) {

        $limit = $request->input('limit');
        $page = $request->input('page');
        $gameid = $request->input('gameid');

        $offset = $limit * ($page - 1);

        $data['orderedItems'] = $this->inter->getcOrderedItems($gameid, $limit, $offset);

        return self::responseMsgCode('OK', $data);
    }
    public function getItemInfo(Request $request) {

        $itemid = $request->input('itemid');
        $data['itemInfo'] = $this->inter->getcItemInfo($itemid);
        return self::responseMsgCode('OK', $data);
    }
    public function create(ItemCreateRequest $request) {

        if (self::hasRequestError($request)) {
            return self::responseRequestError($request);
        }

        $uid = $request->input('uid');
        $resp = $this->inter->createItem($request->all(), $uid);

        if (self::isErrorMsg($resp)) return self::responseMsgCode($resp);

        return self::responseMsgCode('OK');
    }
    public function update(ItemUpdateRequest $request) {

        if (self::hasRequestError($request)) {
            return self::responseRequestError($request);
        }

        $param = $request->all();
        $uid = $request->input('uid');
        $is = self::isBelongs($uid, 'userid', $param['itemid'], Item::class);

        if (!$is) return self::responseMsgCode('ERROR');
        //dd($param);exit;
        $resp = $this->inter->updateItem($request->all(), $uid);
        if (self::isErrorMsg($resp)) self::responseMsgCode($resp);
        return self::responseMsgCode('OK');
    }

    public function endItem(Request $request) {
        $uid = $request->input('uid');
        $itemid = $request->input('itemid');
        $itemStatus = $request->input('item_status');
        $is = self::isBelongs($uid, 'userid', $itemid, Item::class);

        if (!$is) return 'ERROR';
        $resp = $this->inter->endItem($itemid,$itemStatus);
        if (self::isErrorMsg($resp)) return $resp;
        return 'OK';
    }

    // Announcements
    public function getAnnouncements(Request $request) {

        $uid = $request->input('uid');
        $limit = $request->input('limit');
        $private = $request->input('private');
        $itemid = $request->input('itemid');
        $data['is'] = false;
        if ($private || $private == -1) {

            $is = self::isBelongs($uid, 'userid', $itemid, Item::class);
            $count = count(UserAPI::getItemOrderIds($itemid, $uid));
            $data['is'] = $is;
            if (!$count && !$is) return self::responseMsgCode('ERROR');

            if (!$private && $private != -1) {
                $privateArr = [$private];
            } else {
                $privateArr = [0, 1];
            }

        } else {

            $privateArr = [0];
        }

        $data['announcements'] = ItemAPI::getAnnouncements($itemid, $limit, 0, $privateArr);
        return self::responseMsgCode('OK', $data);
    }

    public function createAnnouncement(Request $request) {

        $uid = $request->input('uid');
        $itemid = $request->input('itemid');
        $is = self::isBelongs($uid, 'userid', $itemid, Item::class);

        if (!$is) return self::responseMsgCode('ERROR');

        $lastAnno = ItemAnnouncement::where("itemid",$itemid)->orderBy('created_at','desc')->first();
        if ($lastAnno) {
            $cdTime = strtotime($lastAnno->created_at) + config('S.ANNOUNCEMENT_CD');
            if ($cdTime > time()) return self::responseMsgCode('ANNOUNCEMENT_CD_CODE');
        }
        $resp = $this->inter->createAnnouncement($request->all(), $uid);

        if (self::isErrorMsg($resp)) return self::responseMsgCode($resp);

        return self::responseMsgCode('OK');

    }

    // Games
    public function getGames() {
        $data = self::readData($this, ['games']);
        return self::responseMsgCode('OK', $data);

    }
    public function getComments(Request $request) {
        $itemid = $request->input('itemid');
        $limit = $request->input('limit');
        $page = $request->input('page');
        return self::responseMsgCode('OK', $this->inter->getComments($itemid,$limit,$page));
    }
    public function createComment(Request $request) {
        $uid = $request->input('uid');
        $count = count(UserAPI::getItemOrderIds($request->input('itemid'), $uid));
        if (!$count) return self::responseMsgCode('ERROR');

        $resp = $this->inter->createComment($request->all(), $uid);
        if (self::isErrorMsg($resp)) return self::responseMsgCode($resp);

        return self::responseMsgCode('OK');
    }
    public function sponsorsList(Request $request) {
        $uid = $request->input('uid');
        $itemid = $request->input('itemid');
        $page = $request->input('page');
        $limit = $request->input('limit');
        $optionid = $request->input('optionid');
        $offset = $limit * ($page - 1);
        $is = self::isBelongs($uid, 'userid', $itemid, Item::class);
        if (!$is) return 'ERROR';
        $data['sponsorsList'] = $this->inter->getPartakeInfo($itemid, $limit , $offset , $optionid);
        $data['pager']['total'] = $data['sponsorsList']['total'];
        unset($data['sponsorsList']['total']);
        $data['pager']['count'] = $data['sponsorsList']['count'];
        unset($data['sponsorsList']['count']);
        $data['options'] = ItemAPI::getOptions($itemid);
        $data['pager']['page'] = $page;
        $data['pager'] = (object) $data['pager'];
        $data['itemid'] = $itemid;
        $data['optionid'] = $optionid;
        return $data;
    }
   public function settlesList(Request $request) {
        $uid = $request->input('uid');
        $page = $request->input('page');
        $limit = $request->input('limit');
        $offset = $limit * ($page - 1);
        $itemid = $request->input('itemid');
        $is = self::isBelongs($uid, 'userid', $itemid, Item::class);
        if (!$is) return 'ERROR';
        $data['settles'] = $this->inter->getSettles($itemid, $limit , $offset );
        $data['pager']['total'] = $data['settles']['total'];
        unset($data['settles']['total']);
        $data['pager']['count'] = $data['settles']['count'];
        unset($data['settles']['count']);
        $data['pager']['page'] = $page;
        $data['pager'] = (object) $data['pager'];
        $data['itemid'] = $itemid;

        return $data;

    }
    public function downLoadPartakeInfo(Request $request) {

        $uid = $request->input('uid');
        $itemid = $request->input('itemid');
        $is = self::isBelongs($uid, 'userid', $request->input('itemid'), Item::class);
        if (!$is) return self::responseMsgCode('ERROR');
        $data = $this->inter->getPartakeInfo($itemid,$limit = 9999, $offset = 0);
        unset($data['total']);
        unset($data['count']);
        foreach($data as $index => &$value) {
            if ($value->item_option_title == "") {
                $value->item_option_cost = $value->order_cost / $value->order_amount;
                $value->item_option_title = "直接赞助";
            }
            $data2[$index] = Format::removeAttrs($value, ['order_serial','level','qq','wechat']);
        }

        $rowTitle = ["排序","赞助订单号","赞助游戏","赞助游戏类型","赞助人","赞助人联系方式",
            "赞助选项","赞助选项金额","实际赞助数量", "实际赞助金额","赞助留言","赞助时间"];

        if(!count($data2)) {
            foreach ($rowTitle as $value) {
                $temp[]= "暂无数据";
            }
            $data2[0] = (object) $temp;
        }

        $width = ['A' => 5,'B' => 15,'C' => 15,'D' => 10,
            'E' => 20,'F' => 15,'G' => 30,'H' => 30,
            'I' => 30,'J' => 30,'K' => 30,'L' => 30,'M' => 30];

        OutputFile::downloadXls($rowTitle, (object) $data2, $width, "赞助名单", 'xlsx');

    }
}