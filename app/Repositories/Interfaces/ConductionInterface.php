<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 16:58
 */

namespace App\Repositories\Interfaces;


interface ConductionInterface
{
    public function getcGames($group = 0);

    public function getcWebNavbar();

    public function getcWebBanners();

    public function getcWebAdvers();

    public function getcWebRecommandItems();

    public function getNews($limit = 5 ,$offset = 0);

    public function createNews($param, $uid);
}