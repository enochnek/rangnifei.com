<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 11:38
 */

namespace App\Services\Operator;

use App\Services\API;
use App\Models\Config\EmailLog;
use Illuminate\Support\Facades\DB;

class LogAPI extends API
{
    protected $class = EmailLog::class;
    protected static $api = null;

    protected static function initialApi() {
    	if (self::$api == null)
    		self::$api = new self;

    	return self::$api;
    }

    public static function createEmailLog($param) {

     	$api = self::initialApi();
     	$resp = $api->create($param, EmailLog::class);
     	return $resp;
    }

}