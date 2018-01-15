<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 16:58
 */

namespace App\Repositories\Interfaces;


interface ItemHandleInterface extends ItemInterface
{
    public function createItem($param, $userid);

    public function updateItem($param, $userid);

    public function endItem($itemid, $itemStatus);

    public function createAnnouncement($param, $userid);

    public function createComment($param, $userid);

    public function createSeason($itemid);
}
