<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 18:30
 */
namespace App\Http\Controllers\Conduction;

use App\Http\Controllers\BaseController;
use App\Repositories\Interfaces\ConductionInterface;
use Illuminate\Http\Request;

class NewsController extends BaseController
{

    private $inter;

    function __construct(ConductionInterface $inter)
    {
        $this->inter = $inter;
    }
    public function createNews(Request $request) {

        $uid = $request->session()->get('user')->id;
        $isLogin = isset($uid) ?  true : false;

        if(!$isLogin)
            return self::responseMsgCode('NOT_LOGIN');

        $resp = $this->inter->createNews($request->all(),$uid);

        return self::responseMsgCode($resp);
    }

    public function getNews(Request $request) {

        $limit = $request->input('limit');
        $page = $request->input('page');
        $limit = !empty($limit) ? $limit : 5;
        $page = !empty($page) ? $limit : 1;
        $offset = ($page - 1) * $limit;
        $resp = $this->inter->getNews($limit,$offset);
        return self::responseMsgCode('OK',$resp);
    }



 
}