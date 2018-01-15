<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/9/28
 * Time: 20:42
 */

namespace App\Services\Traits\Cacher;

use App\Services\Conduction\BannerAPI;
use App\Services\Conduction\RecommandAPI;
use App\Services\Item\ItemAPI;
use Illuminate\Support\Facades\Cache;

trait ConductionCacherList
{

    public function navbar()
    {
        $navbar = null;
        if (!($navbar = Cache::get('navbar'))) {
            $navbar = BannerAPI::getByPlace(1, 1);
            $navbar = json_decode($navbar);
            Cache::put('navbar', $navbar, 3600 * 24);
        }
        return $navbar;
    }

    public function banners()
    {
        $banners = null;
        if (!($banners = Cache::get('banners'))) {
            $banners = BannerAPI::getByPlace(2);
            $banners = json_decode($banners);
            Cache::put('banners', $banners, 3600 * 24);
        }
        return $banners;
    }

    public function advers()
    {
        $advers = null;
        if (!($advers = Cache::get('advers'))) {
            $advers = BannerAPI::getByPlace(3, 4);
            $advers = json_decode($advers);
            Cache::put('advers', $advers, 3600 * 24);
        }
        return $advers;
    }

    public function games()
    {
        $games = null;
        if (!($games = Cache::get('games'))) {
            $games = ItemAPI::getGames();
            $games = json_decode($games);
            Cache::put('games', $games, 3600 * 24);
        }
        return $games;
    }

    public function recommands($group)
    {
        $recommands = null;
        if (!($recommands = Cache::get('recommands'))) {
            $recommands = RecommandAPI::getItemids();
            $recommands = json_decode($recommands);
            Cache::put('recommands', $recommands, 3600 * 24);
        }
        return $recommands;
    }
}