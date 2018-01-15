<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 20:27
 */

namespace App\Services\Conduction;

use App\Models\Conduction\Banner;
use App\Services\API;

class BannerAPI extends API
{
    protected $class = Banner::class;

    public static function getByPlace($place, $limit = 10)
    {
        if ($place) {
            return Banner::where('banner_place', $place)
                ->orderBy('banner_priority', 'desc')
                ->orderBy('created_at', 'desc')
                ->take($limit)->get();

        } else {
            return Banner::orderBy('banner_priority', 'desc')
                ->orderBy('created_at', 'desc')
                ->take($limit)->get();
        }
    }
}