<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 16:58
 */

namespace App\Repositories\Interfaces;


interface UserHandleInterface extends UserInterface {

    public function updateUserInfo($param, $userid);
    public function createOrder($param, $userid, $status = 0);
    public function createNotice($param,  $targetUserid, $noticeType = 2, $sourceUserid = 0);
    public function createVertification($param, $userid);
    public function successVertification($userid);
    public function failVertification($userid);

    public function favoriteItem($userid, $itemid);
    public function unFavoriteItem($userid, $itemid);

    public function balancePay($title, $userid, $money, $type = 1);
}