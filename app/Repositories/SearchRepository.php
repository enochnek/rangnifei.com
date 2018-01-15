<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 16:22
 */

namespace App\Repositories;


use App\Models\Item\Item;
use App\Repositories\Interfaces\SearchInterface;
use App\Services\Item\ItemAPI;
use App\Services\Traits\Cacher\ItemCacherList;
use App\Utils\Format;
use TomLingham\Searchy\Facades\Searchy;

class SearchRepository implements SearchInterface
{

    use ItemCacherList;
    public function itemSearch($searchContent) {

        $items = Searchy::item('item_title')->query($searchContent)->select('id')->get();
        $games = Searchy::game('game_name')->query($searchContent)->get();
        $users = Searchy::user('username')->query($searchContent)->get();
        $gamesid = [];
        $userid = [];
        $itemid = [];

        foreach ($items as $key => $item) {
            $itemid[] = $item->id;
        }

        foreach ($games as  $game) {
            $gamesid[] = $game->id;
        }

        foreach ($users as  $user) {
            $userid[] = $user->id;
        }

        $games_items = Item::whereIn("item_gameid",$gamesid)->get(['id']);
        $users_items = Item::whereIn("userid",$userid)->get(['id']);
        
        foreach ($games_items as $games_item) {
            $itemid[] = $games_item->id;
        }
        foreach ($users_items as $users_item) {
            $itemid[] = $users_item->id;
        }

        $itemid = array_values(array_unique($itemid));
        if (count($itemid) > config('S.MAX_SEARCH')) {
            $itemid = array_slice($itemid,0,config('S.MAX_SEARCH'));
        }

        $items = [];
        foreach ($itemid as $id) {
            //$param = Item::find($id);
            $param = $this->itemInfo($id);
            $param->dynamic = $this->itemDynamic($id);
            //$param->item_cata = config('W.ITEM_CATAID_' . $param->item_cataid);

            $param->user = Format::getAttrs($param->user,
                ['id', 'username', 'verification'], true);
            $param->game = Format::getAttrs($param->game,
                ['id', 'game_name', 'game_iconurl'], true);

            $items[] = Format::removeAttrs($param,
                ['options', 'item_text', 'item_fake', 'item_weburl', 'item_interval'], true);


            //dd($param);


//            $user = $param->user;
//            unset($param->user);
//            $param->user = Format::getAttrs(($user),
//                ['id','username','verification'],true);
//
//            $game = $param->game;
//            unset($param->game);
//            $param->game = Format::getAttrs(($game),
//                ['id','game_name'],true);
//
//            $param->dynamic = ItemAPI::getDynamic($id);
//            $param->item_cata = config('W.ITEM_CATAID_' . $param->item_cataid);
//
//            $items[] = Format::removeAttrs(($param),
//                ['item_expect','item_fund','item_priority','item_fake',
//                    'item_fake','item_interval'],true);

        }
        return $items;
    }

}