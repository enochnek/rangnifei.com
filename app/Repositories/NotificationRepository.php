<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 16:22
 */

namespace App\Repositories;

use App\Models\Item\ItemOption;
use App\Models\User\User;
use App\Models\User\UserProfile;
use App\Models\User\UserVerification;
use App\Repositories\Interfaces\NotificationInterface;
use App\Services\Config\NotificationAPI;
use App\Utils\Format;
use App\Services\API;

class NotificationRepository implements NotificationInterface
{
    public function notification($param, $useid = 0) {

    }

    public function create($param, $userid = 0) {
        $param['noti_userid'] = $userid;
        $param = Format::filter($param, ['noti_userid', 'noti_status', 'noti_content',
            'noti_group', 'noti_readonly','noti_publish']);
        if (NotificationAPI::create($param)) return 'OK';
    }

    public function delete($id) {

        if(NotificationAPI::delete($id)) return 'OK';
    }

    public function update($param) {
        // NotificationAPI::
    }
    
}