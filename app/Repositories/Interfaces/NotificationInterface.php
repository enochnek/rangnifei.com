<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 16:58
 */

namespace App\Repositories\Interfaces;


interface NotificationInterface
{
    public function notification($param, $userid = 0);

    public function create($param, $userid = 0);

    public function delete($id);
    
    public function update($param);
}