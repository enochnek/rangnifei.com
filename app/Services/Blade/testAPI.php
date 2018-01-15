<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/28
 * Time: 13:02
 */

namespace App\Services\Blade;

use App\Models\Item\Game;

class testAPI
{

    public function getGames()
    {
        return json_decode(Game::all());
    }

    public function test()
    {
        return '12345678';
    }
}