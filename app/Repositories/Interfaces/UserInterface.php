<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 16:58
 */

namespace App\Repositories\Interfaces;


interface UserInterface {

    public function getUserInfo($userid);
    public function getMyUserInfo($userid);

    public function getMyFavorites($userid, $limit = 10, $offset = 0);
    public function getMyOrders($userid, $limit = 10, $offset = 0);
    public function getMyItems($userid, $limit = 10, $offset = 0);
}