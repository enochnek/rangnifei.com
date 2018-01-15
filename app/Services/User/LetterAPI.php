<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 20:27
 */

namespace App\Services\User;

use App\Models\User\UserLetter;
use App\Services\API;

class LetterAPI extends API
{
    protected $class = UserLetter::class;
    public static function getLetter($uid = 0, $limit = 5, $offset = 0)
    {
        return UserLetter::where('target_userid', $uid)
            ->orderBy('created_at', 'desc')
            ->offset($offset)->take($limit)->get();
    }
    public static function flagRead($uid) {

        return UserLetter::where('target_userid', $uid)->update(['is_read' => 1]);
    }

    public static function createLetter($param) {
        
        $api = new self();
        return self::createModel($param, $api->class);
    }
}