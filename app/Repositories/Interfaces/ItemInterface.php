<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 16:58
 */

namespace App\Repositories\Interfaces;


interface ItemInterface
{

    public function getcOrderedItems($gameid = 0, $limit = 10, $offset = 0);
    public function getcItemInfo($itemid);
    public function getcItem($itemid);
    public function getComments($itemid, $limit, $offset);
    public function getPartakeInfo($itemid, $limit = 3, $offset = 0, $optionid = -1);
    public function getSettles($itemid, $limit = 5, $offset = 0);
}
