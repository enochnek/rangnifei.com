<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 11:05
 */

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserHandleInterface;

class UserOrderController extends UserController {

    function __construct(UserHandleInterface $inter) {
        parent::__construct($inter);
        $this->inter = $inter;
    }

    public function create(Request $request) {

        $uid = $request->input('uid');
        $resp = $this->inter->createOrder($request->all(), $uid, 1);

        if (self::isErrorMsg($resp))
            return self::responseMsgCode($resp);

        return self::responseMsgCode('OK');
    }
}