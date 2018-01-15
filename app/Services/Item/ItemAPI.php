<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 11:38
 */

namespace App\Services\Item;

use App\Models\Item\Game;
use App\Models\Item\Item;
use App\Models\Item\ItemAnnouncement;
use App\Models\Item\ItemComment;
use App\Models\Item\ItemHistory;
use App\Models\Item\ItemOption;
use App\Models\User\Order;
use App\Services\API;
use Illuminate\Support\Facades\DB;

class ItemAPI extends API
{
    protected $class = Item::class;

    // Item
    public static function getOrdered($gameid, $limit = 10, $offset = 0, $cols = ['*']) {

        if ($gameid) {
            return Item::where('item_gameid', $gameid)
                ->orderByRaw('item_fund + item_priority desc')
                ->offset($offset)->take($limit)
                ->get($cols);
        } else {
            return Item::orderByRaw('item_fund + item_priority desc')
                ->offset($offset)->take($limit)
                ->get($cols);
        }
    }

    public static function getWith($itemid, $with = ['user', 'game', 'options']) {
        return Item::where('id', $itemid)->with($with)->first();
    }

    public static function getUserItemids($userid, $limit = 10, $offset = 0) {
        return Item::where('userid', $userid)->orderBy('created_at', 'desc')
            ->offset($offset)->take($limit)->get(['id']);
    }

    public static function getOptions($itemid, $exceptUnavailable = false) {

        if ($exceptUnavailable) {
            return ItemOption::where('itemid', $itemid)
                ->where('item_option_unavailable', '0')->get();
        }
        else {
            return ItemOption::where('itemid', $itemid)->get();
        }
    }

    public static function getGames($group = 0) {

        if ($group) {
            return Game::where('game_group', $group)
                ->orderBy('game_priority', 'desc')->get();
        } else {
            return Game::orderBy('game_priority', 'desc')->get();
        }
    }

    public static function getDynamic($itemid) {

        $data['sum'] = DB::table('order')
            ->where('order_itemid', $itemid)
            ->where('order_status', 1)
            ->sum('order_cost');
        $data['num'] = DB::table('order')
            ->where('order_itemid', $itemid)
            ->where('order_status', 1)
            ->get()->count();
        $data['comments_count'] = DB::table('item_comment')
            ->where('itemid', $itemid)
            ->where('parent',0)
            ->get()->count();
        return $data;
    }

    // Announcement
    public static function getAnnouncements(
        $itemid, $limit = 10, $offset = 0, $privateArr = [0]) {

        if (!is_array($privateArr)) $privateArr = [$privateArr];
        return ItemAnnouncement::where('itemid', $itemid)
            ->whereIn('item_anno_private', $privateArr)
            ->orderBy('created_at','desc')
            ->offset($offset)->take($limit)->get();
    }

    public static function getComments($itemid, $limit = 10, $offset = 0) {

        $comments = ItemComment::where('itemid', $itemid)
            ->where('parent', 0)
            ->orderBy('created_at')
            ->offset($offset)->limit($limit)->with('children')->get();
        //dd($comments);
        return $comments;

    }
    public static function getCommentChildren($commentId, $limit = 3, $offset = 0) {

        return ItemComment::where('parent', $commentId)
            ->offset($offset)->limit($limit)->get();
    }

    public static function getOrderRank($itemid) {
        $orders = Order::where('order_itemid',$itemid)
                        ->selectRaw('order_userid,order_itemid,sum(order_cost) as sum,sum(order_amount) as amount')
                        ->where('order_status',1)
                        ->orderBy('sum','desc')
                        ->take(5)->groupBy(['order_userid'])->get();
//        dd($orders);

        if(!$orders->count()) return false;
        foreach ($orders as $key => $value) {
//            dd($value->user->profile->avatar);
            $rank[$key]['avatar'] = $value->user->profile->avatar;
            $rank[$key]['username'] = $value->user->username;
            $rank[$key]['userid'] = $value->user->id;
            $rank[$key]['sum'] = $value->sum;
            $rank[$key]['amount'] = $value->amount;
        }
        return $rank;

    }
    public static function isFake($itemid) {
        return Item::find($itemid)->item_fake;
    }

    public static function getItemStatas($itemid) {
        return Item::find($itemid)->item_status;
    }

    public static function getOrderIds($itemid) {
        $orderIds =  Order::where('order_itemid',$itemid)->get(['id'])->toArray();
        $newOrderIds = [];
        foreach ($orderIds as $value) {
            $newOrderIds[] = $value['id'];
        }
        return $newOrderIds;
    }

    public static function getItemHistoryDynamic($itemid) {
        $itemHistory = ItemHistory::where('itemid',$itemid)->get()->toArray();
        if (!count($itemHistory))
            return false;
        else {

            $data = ItemHistory::where('itemid',$itemid)->selectRaw('sum(item_history_sum) as sum,sum(item_history_num) as num')->get();
            $temp = [];
            for ($i = 0; $i < count($itemHistory); $i ++) {
                $temp = array_merge(json_decode($itemHistory[$i]['item_history_info']),$temp);
            }
        }
        $data = (object)$data->toArray()[0];
        $data->item_history_info = $temp;
        return $data;
    }

    public static function getHistory($itemid) {

        return ItemHistory::where('itemid', $itemid)->get();
    }

}