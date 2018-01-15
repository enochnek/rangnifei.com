<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 16:22
 */

namespace App\Repositories;

use App\Models\Conduction\News;
use App\Repositories\Interfaces\ConductionInterface;
use App\Services\API;
use App\Services\Traits\Cacher\ConductionCacherList;
use App\Services\Traits\Cacher\ItemCacherList;
use App\Utils\CacherReader;
use App\Utils\Format;

class ConductionRepository implements ConductionInterface
{
    use ConductionCacherList;
    use ItemCacherList;
    private $reader;

    function __construct()
    {
        $this->reader = new CacherReader($this);
    }

    public function getcGames($group = 0) {

        $games = $this->games();

        if ($group) {
            $newGames = [];
            foreach ($games as $index => $game) {
                if ($games[$index]->game_group == $group) {
                    array_push($newGames, $game);
                }
            }
            return $newGames;
        }

        return $games;
    }

    public function getcWebNavbar()
    {

        $navbar = $this->navbar();
        return $navbar;
    }

    public function getcWebBanners()
    {

        $banners = $this->banners();
        return $banners;
    }

    public function getcWebAdvers()
    {

        $advers = $this->advers();
        return $advers;
    }

    public function getcWebRecommandItems($group = 0)
    {

        $itemids = $this->recommands(0);

        $items = null;
        foreach ($itemids as $index => $itemid) {
            $items[$index] = $this->itemInfo($itemid);

            $items[$index] = Format::getAttrs($items[$index],
                ['id', 'item_coverurl', 'item_players', 'item_description',
                    'game', 'item_title', 'user'], true);

            $items[$index]->user = Format::getAttrs($items[$index]->user,
                ['id', 'username', 'verification'], true);
            $items[$index]->game = Format::getAttrs($items[$index]->game,
                ['id', 'game_name', 'game_fund'], true);

            $items[$index]->dynamic = $this->itemDynamic($itemid);
        }

        return $items;
    }

    public function createNews($param, $uid) {

        $param = Format::filter($param, ['title', 'content','author','group']);
        $param['userid'] = $uid;
        $resp = API::createModel($param,News::class);
        if ($resp) return 'OK';
        return 'ERROR';
    }

    public function getNews($limit = 5, $offset = 0) {

        $resp = News::orderBy('created_at','desc')->limit($limit)->offset($offset)->get();
        return $resp;
    }
}