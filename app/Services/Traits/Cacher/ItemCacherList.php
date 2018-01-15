<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/9/28
 * Time: 20:42
 */

namespace App\Services\Traits\Cacher;

use App\models\user\UserProfile;
use App\Services\API;
use App\Services\Item\ItemAPI;
use App\User;
use App\Utils\Format;
use Illuminate\Support\Facades\Redis;

trait ItemCacherList
{

    public function orderedItems($param = null) {
	
        $param = Format::filter($param, ['offset', 'limit', 'gameid'], [0, 10, 0]);

        $gameid = $param['gameid'];
        $offset = $param['offset'];
        $limit = $param['limit'];

        $amount = Redis::zcount('items_gameid_' . $gameid, '-inf', '+inf');
        if ($amount && $amount <= $offset) return null;

        $items = null;
        $range = Redis::zrange('items_gameid_' . $gameid, $offset, $offset + $limit - 1);
	
        if ($range) $items = Redis::hmget('items', $range);
	
        if (!$range || !$items) {
            $items = ItemAPI::getOrdered($gameid, 100, 0, ['id']);

            if (!$items->all()) return null;

            foreach ($items as $index => $item) {

                $item = $this->itemInfo($item->id);

                if ($item->item_status == 1 || $item->item_status == 2) {
                    Redis::zadd('items_gameid_' . $gameid, $index, $item->id);
                    Redis::expire('items_gameid_' . $gameid, 3600 * 24);
                } else {
                    return null;
                }
            }

            return $this->orderedItems($param);

        }
	
        foreach ($items as $index => $item) {

            $items[$index] = json_decode($item);

            //if($items[$index]->item_status != 1 && $items[$index]->item_status != 2) continue;

            if ($items[$index]->item_fake) {
                $num = $items[$index]->item_fake;
                $sum = $num * rand(10, 30);
                $comments_count = rand($num, $num*5);
                $items[$index]->dynamic = (object) [
                    'num' => $num*$items[$index]->item_fake,
                    'sum' => $sum*$items[$index]->item_fake,
                    'comments_count' => $comments_count,
                ];

            } else {
                $items[$index]->dynamic = $this->itemDynamic($items[$index]->id);

            }

            $items[$index]->item_cata = config('W.ITEM_CATAID_' . $items[$index]->item_cataid);

            $items[$index]->user = Format::getAttrs($items[$index]->user,
                ['id', 'username', 'verification'], true);
            $items[$index]->game = Format::getAttrs($items[$index]->game,
                ['id', 'game_name', 'game_iconurl'], true);

            $items[$index] = Format::removeAttrs($items[$index],
                ['options', 'item_text', 'item_fake', 'item_weburl', 'item_interval'], true);
        }
	
        return $items;
    }

    public function itemInfo($itemid) {

        $item = null;
        if (!($item = Redis::hget('items', $itemid))) {

            $item = ItemAPI::getWith($itemid);
		     if (!$item) return null;
            $length = count($item->options);
            for ($i = 0; $i < $length; $i++){
                if ($item->options[$i]->item_option_unavailable)
                    unset($item->options[$i]);
            }
            $item = json_encode($item);
            Redis::hset('items', $itemid, $item);
            Redis::expire('items', 3600 * 24 * 7);
        }
        return json_decode($item);
    }

    public function itemDynamic($itemid) {

        if (!($data = Redis::hget('items_dynamic', $itemid))) {
            $data = ItemAPI::getDynamic($itemid);

            $data = json_encode($data);
            Redis::hset('items_dynamic', $itemid, $data);
        }

        return json_decode($data);
    }

    public function itemOrderRank($itemid) {
        if (!($data = Redis::hget('item_rank', $itemid))) {
            $data = ItemAPI::getOrderRank($itemid);
            if($data) {
                $data = json_encode($data);
                Redis::hset('item_rank', $itemid, $data);
            } else return [];
        }
        $data = json_decode($data);
        foreach (($data) as $index => $value) {
           $data[$index]->avatar = UserProfile::where('userid',$value->userid)->first()->avatar;
        }
        return ($data);
    }
}