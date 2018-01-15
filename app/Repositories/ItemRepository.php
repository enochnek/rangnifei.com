<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 16:22
 */

namespace App\Repositories;

use App\Models\Item\Item;
use App\Models\Item\ItemComment;
use App\Models\Item\ItemHistory;
use App\Models\Operator\Settle;
use App\Models\User\User;
use App\Models\User\UserProfile;
use App\Models\User\Order;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\Interfaces\ItemHandleInterface;
use App\Services\API;
use App\Services\Item\ItemAPI;
use App\Services\Item\ItemHandleAPI;
use App\Services\Traits\Cacher\CounterCacherList;
use App\Services\Traits\Cacher\ItemCacherList;
use App\Utils\CacherReader;
use App\Utils\Format;
use Illuminate\Support\Facades\Redis;

class ItemRepository implements ItemInterface, ItemHandleInterface
{
    use ItemCacherList;
    use CounterCacherList;
    private $reader;

    function __construct() {
        $this->reader = new CacherReader($this);
    }

    public function getcOrderedItems($gameid = 0, $limit = 10, $offset = 0) {

        $param = Format::filter(null, ['gameid', 'offset', 'limit'],
            [$gameid, $offset, $limit]);

        $items = $this->reader->get('orderedItems', $param);
        return $items;
    }

    public function getcItemInfo($itemid) {

        $item = $this->reader->get('itemInfo', $itemid);
        $temp = json_decode(UserProfile::where('userid', $item->user->id)->first());
        $userA = Format::getAttrs($item->user, ['id', 'username', 'verification']);
        $userB = Format::getAttrs($temp, ['avatar', 'introduction', 'nickname']);
        if (!is_array($userB)) $userB = Format::filter(null,
            ['avatar', 'introduction', 'nickname'], ['', '', '']);

        $item->user = (object) array_merge($userA, $userB);
        $item->game = Format::getAttrs($item->game, ['id', 'game_name', 'game_iconurl'], 1);
        $item->announcements = json_decode(ItemAPI::getAnnouncements($itemid, 2, 0));

        /*$item->comments = json_decode(ItemAPI::getComments($itemid));
        foreach ($item->comments as $key => $value) {

            $value->children = json_decode(ItemAPI::getChildrenComments($value->itemid,$value->id));
        }*/

        $item->dynamic = $this->itemDynamic($item->id);
        $item->item_status_name = config('W.ITEM_STATUS_' . $item->item_status);
        $item->item_cata_name = config('W.ITEM_CATAID_' . $item->item_cataid);
        $item->is_sponsor =  in_array($item->item_status,config("W.ITEM_CAN_STATUS"));
        $item->rank = $this->itemOrderRank($itemid);
        return $item;
    }

    public function getcItem($itemid) {

        $param = $this->itemInfo($itemid);
        $param->dynamic = $this->itemDynamic($itemid);
        //$param->item_cata = config('W.ITEM_CATAID_' . $param->item_cataid);

        $param->user = Format::getAttrs($param->user,
            ['id', 'username', 'verification'], true);
        $param->game = Format::getAttrs($param->game,
            ['id', 'game_name', 'game_iconurl'], true);

        $item = Format::removeAttrs($param,
            ['options', 'item_text', 'item_fake', 'item_weburl', 'item_interval'], true);

        return $item;
    }

    public function createItem($param, $userid) {

        // ../create?item_options={item_options:[['a', 'b'], [1, 2]]}
        $optionArr = isset($param['item_options'])? $param['item_options']:null;

        $param['userid'] = $userid;

        $param['ended_at'] = date('Y-m-d H:i:s',1500000000);

        $param['item_status'] = config('W.ITEM_ORININ_STATUS');
        $param = Format::filter($param, ['userid', 'item_cataid', 'item_gameid',
            'item_coverurl', 'item_title', 'item_status', 'item_players', 'item_description',
            'item_weburl', 'item_note', 'item_text','ended_at']);

        if ($optionArr) {
            array_pop($optionArr);
            $options = Format::array2dReform($optionArr, ['item_option_cost', 'item_option_title']);
        } else
            $options = null;

        $resp = ItemHandleAPI::createItem($param, $options);
        if ($resp) return $resp;
        return 'ERROR';
    }
    public function updateItem($param, $userid) {
        $options = isset($param['item_options']);
        $optionArr = $options ? $param['item_options']:null;

        if (!isset($param['id'])) $param['id'] = $param['itemid'];

        $originIds = isset($param['origin_ids']);
        $originIds = $originIds ? $param['origin_ids']:[];
        $param = Format::filter($param, ['id',  'item_coverurl', 'item_title',
            'item_players', 'item_description', 'item_weburl', 'item_note', 'item_text']);
        if ($optionArr)
            $options = Format::array2dReform($optionArr,
            ['item_option_cost', 'item_option_title', 'id']);
        else
            $options = [];

        $resp = ItemHandleAPI::updateItem($param, $options, $originIds);
        if ($resp) {
            Redis::hdel('items', $param['id']);
            return $resp;
        }
        return 'ERROR';
    }
    public function endItem($itemid,$itemStatus)
    {
        $param['id'] = $itemid;
        $param['ended_at'] = date('Y-m-d H:i:s',time());
        $param['item_status'] = $itemStatus;
        $currentStatus = ItemAPI::getItemStatas($itemid);
        $item = Item::find($itemid);
        $endatTimeStamp = strtotime($item->ended_at);
        $currentTimeStamp  = strtotime(date('Y-m-d H:i:s',time()));
        $cdTime = ($currentTimeStamp-$endatTimeStamp) / 86400;
        switch ($currentStatus) {
            case 5:
                //  当前状态为5(已结束),并且不能更改为除 1(可参与) 和 6(新赛季预热) 其他以外的状态
                if ( !($currentStatus == config('W.ITEM_STATUS_5_CODE') &&
                    ($itemStatus == config('W.ITEM_STATUS_1_CODE') ||
                        $itemStatus == config('W.ITEM_STATUS_6_CODE') ))) {

                    return 'ITEM_UPDATE_END_STATUS';
                }
                break;
            case 1:
                // 当前状态为1(可参与),并且不能更改为除 4(已暂停) 和 5(已结束) 其他以外的状态
                if ( !($currentStatus == config('W.ITEM_STATUS_1_CODE') &&
                    ($itemStatus == config('W.ITEM_STATUS_4_CODE') ||
                        $itemStatus == config('W.ITEM_STATUS_5_CODE') ))) {
                    return 'ITEM_PARTAKE_STATUS';
                }
                break;
            case 2:
                // 当前状态为2(已完成,可参与),并且不能更改为除 3(已完成) 其他以外的状态
                if ( !($currentStatus == config('W.ITEM_STATUS_2_CODE') &&
                    ($itemStatus == config('W.ITEM_STATUS_3_CODE') ))) {
                    return 'ITEM_COMPLETE_STATUS';
                }
                break;
            case 4:
                // 当前状态为4(已暂停),并且不能更改为除 1(可参与) 和 5(已结束) 其他以外的状态
                if ( !($currentStatus == config('W.ITEM_STATUS_4_CODE') &&
                    ($itemStatus == config('W.ITEM_STATUS_1_CODE') ||
                        $itemStatus == config('W.ITEM_STATUS_5_CODE') ))) {
                    return 'ITEM_PAUSE_STATUS';
                }
                break;
            case 6:
                // 当前状态为6(新赛季预热),并且不能更改为除 1(可参与) 其他以外的状态
                if ( !($currentStatus == config('W.ITEM_STATUS_6_CODE') &&
                    ($itemStatus == config('W.ITEM_STATUS_1_CODE') ))) {
                    return 'ITEM_SEASON_STATUS';
                }
                if ($itemStatus == config('W.ITEM_STATUS_6_CODE') || $itemStatus == config('W.ITEM_STATUS_1_CODE')) {
                    $settleCount = Settle::where("settle_status",'!=',1)->where('settle_itemid',$itemid)->get()->count();
                    if ($settleCount) return 'ITEM_SETTLE';
                }

                break;
            case 0:
                if ($currentStatus == 0) return 'ITEM_AUDIT_STATUS';
        }

        // 已结束更改为已结束,默认不做任何操作.
        if ($currentStatus == config('W.ITEM_STATUS_5_CODE') && ($itemStatus == config('W.ITEM_STATUS_5_CODE'))) {
            return true;
        }
        // 不能在已结束3天内更改任何状态...
        if ( ($currentStatus == config('W.ITEM_STATUS_5_CODE')) && ($cdTime < config('W.ITEM_END_STATUS_CD'))) {
            return 'ITEM_NOT_UPDATE_STATUS';
        } else {

            $resp = $this->createSeason($itemid);
            if ($resp) {
                $item->ended_at = $param['ended_at'];
                $item->created_at = $param['ended_at'];
                $item->item_status = $itemStatus;
                $item->item_season += 1;
                $resp = $item->save();
                Redis::hdel('items', $param['id']);
                return $resp;
            }
        }
        // 更改状态
        $api = new ItemAPI();
        $resp = $api->update($param);
        if ($resp) {
            Redis::hdel('items', $param['id']);
            return $resp;
        }
        return 'ERROR';
    }
    public function createSeason($itemid) {
        $itemHistory = ItemAPI::getItemHistoryDynamic($itemid);
        $item = Item::find($itemid);
        $data = ItemAPI::getDynamic($itemid);
        $orderIds = ItemAPI::getOrderIds($itemid);
        if($itemHistory) {
            $param['item_history_sum'] = $data['sum'] - $itemHistory->sum;
            $param['item_history_num'] = $data['num'] - $itemHistory->num;
            $param['item_history_start'] = $item->created_at;
            $param['item_history_end'] = date('Y-m-d H:i:s',time());
            $param['item_history_text'] = $item->item_text;
            $historyOrderIds = $itemHistory->item_history_info;
        } else {
            $param['item_history_sum'] = $data['sum'];
            $param['item_history_num'] = $data['num'];
            $param['item_history_start'] = $item->created_at;
            $param['item_history_end'] = date('Y-m-d H:i:s',time());
            $param['item_history_text'] = $item->item_text;
            $historyOrderIds = [];

        }
        $param['itemid'] = $itemid;
        $param['item_history_season'] = $item->item_season;
        if (count($historyOrderIds)) {
            $param['item_history_info'] = json_encode( array_values(array_diff($orderIds,$historyOrderIds)),true);
        } else {
             $param['item_history_info'] = json_encode($orderIds,true);
        }
        $resp = ItemAPI::createModel($param,ItemHistory::class);
        if ($resp) return true;
        return false;

    }

    public function createAnnouncement($param, $userid)  {

        $param = Format::filter($param, ['itemid', 'item_anno_content', 'item_anno_private']);

        $param['userid'] = $userid;

        $resp = ItemHandleAPI::createAnnouncement($param);
        if ($resp) return $resp;
        return 'OK';
    }

    public function getComments($itemid, $limit, $offset) {

        $comments = ItemAPI::getComments($itemid, $limit, $offset);
        $data = null;
        foreach ($comments as $index => $comment) {

            $user = json_decode($comment->user);
            unset($comment->user);
            $comment->user = Format::getAttrs($user,
                ['id', 'username', 'level', 'verification', 'admin'], true);

            $comment->user->avatar = $comment->userProfile->avatar;
            unset($comment->userProfile);

            $children = $comment->children;
            if (count($children)) {
                foreach($children as $in => $child) {

                    $childUser = json_decode($child->user);
                    unset($comment->children[$in]->user);
                    $comment->children[$in]->user =
                        Format::getAttrs($childUser,
                            ['id', 'username', 'level', 'verification', 'admin'], true);


                    $comment->children[$in]->user->avatar =
                        $comment->children[$in]->userProfile->avatar;
                    unset($comment->children[$in]->userProfile);

                }
            }
            $data[$index] = json_decode($comment);
        }

        //$data['count'] = API::getCount('itemid', $itemid, ItemComment::class);
        return $data;
    }

    public function createComment($param, $userid) {

        $param = Format::filter($param, ['itemid', 'item_comment_content','parent']);

        /*$orderCount = Order::where('order_userid', $userid)
            ->where('order_itemid', $param['itemid'])
            ->get()->count();*/

        $param['userid'] = $userid;
        $param['parent'] = isset($param['parent']) ? $param['parent'] : 0;
        $resp = ItemHandleAPI::createComment($param);
        if ($resp) {
            Redis::hdel('items_dynamic', $param['itemid']);
            return $resp;
        }
        return 'ERROR';
    }

    public function getPartakeInfo($itemid, $limit = 3,$offset = 0, $optionid = -1) {
            if ($optionid == -1) {
                $order = Order::where('order_itemid', $itemid)
                    ->orderBy('order_serial', 'asc')
                    ->limit($limit)->offset($offset)->get();
                $count = Order::where('order_itemid', $itemid)->get()->count();
                $data['total'] = (int) (($count-1)/$limit + 1);
                if ($data['total'] < 1) $data['total'] = 1;
                $data['count'] = $count;
            } else {
                $order = Order::where('order_itemid', $itemid)
                    ->orderBy('order_serial', 'asc')
                    ->where('order_optionid',$optionid)
                    ->limit($limit)->offset($offset)->get();
                $count = Order::where('order_itemid', $itemid)
                    ->where('order_optionid',$optionid)->get()->count();
                $data['total'] = (int) (($count-1)/$limit + 1);
                if ($data['total'] < 1) $data['total'] = 1;
                $data['count'] = $count;
            }

            foreach ($order as &$value) {
                if ($value->option) {
                    $value->item_option_title = $value->option->item_option_title;
                    $value->item_option_cost = $value->option->item_option_cost;
                } else{
                    $value->item_option_title = "无偿赞助";
                    $value->item_option_cost = $value->order_cost / $value->order_amount;
                }
                $value->game_name = $value->item->game->game_name;
                $value->cata = config('W.ITEM_CATAID_' . $value->item->item_cataid);
                $value->username = $value->item->user->username;
                $value->phone = $value->item->user->phone;
                $value->level = $value->item->user->level;
                $value->qq = $value->item->user->profile->qq;
                $value->wechat = $value->item->user->profile->wechat;

                $value = Format::getAttrs(json_decode($value),
                    ['order_number','game_name','order_serial','cata','username',
                        'phone','item_option_title','item_option_cost',
                        'order_amount','order_cost',
                        'order_note','level','qq','wechat','created_at'],true);
                $data[] = $value;
            }

        return $data;
    }

    public function getSettles($itemid, $limit = 5, $offset = 0) {
        $settles = Settle::where('settle_itemid',$itemid)->limit($limit)->offset($offset)->get();
        $count = Settle::where('settle_itemid', $itemid)
            ->get()->count();
        $settles['total'] = (int) (($count-1)/$limit + 1);
        if ($settles['total'] < 1) $data['total'] = 1;
        $settles['count'] = $count;
        return ($settles);

    }

}