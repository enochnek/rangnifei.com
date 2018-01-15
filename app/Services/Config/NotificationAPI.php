<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 11:38
 */

namespace App\Services\Item;

use App\Models\Item\Game;
use App\Models\Item\Item;
use App\Models\Item\ItemAnnouncement;
use App\Models\Item\ItemComment;
use App\Models\Config\Notification;
use App\Services\API;
class ItemAPI extends API
{
    protected $class = Notification::class;

    public static function getNotification($limit, $offset, $userid = 0, $group = 0) {

        if($userid) {
            return Notification::where('noti_userid', $userid)->orderBy('noti_group', 'desc')
                ->orderBy('created_at','desc')
                ->offset($offset)->take($limit)->get();
        } else {
            return Notification::orderBy('noti_group', 'desc')
                ->orderBy('created_at','desc')
                ->offset($offset)->take($limit)->get();
        }

    }
    
}