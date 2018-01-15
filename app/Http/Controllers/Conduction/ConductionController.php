<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 18:30
 */
namespace App\Http\Controllers\Conduction;

use App\Http\Controllers\BaseController;
use App\Services\Traits\Cacher\ConductionCacherList;

class ConductionController extends BaseController
{
    use ConductionCacherList;

    public function getConductions() {

        $data = self::readData($this, ['navbar', 'banners', 'advers']);

        return self::responseMsgCode('OK', $data);
    }

 
}