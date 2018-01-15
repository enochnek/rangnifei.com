<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 11:05
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\UpdateUserProfileRequest;
use App\Models\User\User;
use App\Repositories\Interfaces\UserInterface;
use App\Utils\Format;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserHandleInterface;

class UserProfileController extends UserController {

    function __construct(UserHandleInterface $inter) {
        parent::__construct($inter);
        $this->inter = $inter;
    }

    public function updateProfile(UpdateUserProfileRequest $request) {

        $uid = $request->input('uid');

        $param = Format::filter($request->all(),
            ['avatar', 'sex', 'qq', 'wechat', 'introduction', 'alipay', 'email'],
            ['', '', '', '', '', '', '']);

        $resp = $this->inter->updateUserInfo($param, $uid);

    	return self::responseMsgCode($resp);
    }
}