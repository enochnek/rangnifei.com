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
use App\models\user\UserVerification;
use App\Repositories\Interfaces\AuthInterface;
use App\Services\User\AuthAPI;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserHandleInterface;
use Illuminate\Support\Facades\Session;
class VertificationController extends BaseController
{	

	private $inter;

    function __construct(UserHandleInterface $inter)
    {
        $this->inter = $inter;
    }

    public function create(Request $request) {
    	
    	$userid = $request->session()->get('user')->id;

    	$verify = UserVerification::where("userid",$userid)->where("status",0)->get()->count();
        if ($verify)  return self::responseMsgCode('EXIST_VERIFY');
    	$resp = $this->inter->createVertification($request->all(),$userid);

    	return self::responseMsgCode($resp);
    }

    public function success(Request $request) {

    	$id = $request->input('id');
    	$resp = $this->inter->successVertification($id);
    	return self::responseMsgCode($resp);

    }
    public function fail(Request $request) {
    	
    	$id = $request->input('id');
    	$resp = $this->inter->failVertification($id);
    	return self::responseMsgCode($resp);

    }

}