<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 11:38
 */

namespace App\Services\Operator;

use App\Models\Item\Game;
use App\Models\Item\Item;
use App\Models\Item\ItemAnnouncement;
use App\Models\Item\ItemOption;
use App\Models\Operator\Settle;
use App\Services\API;
use Hamcrest\Core\Set;
use Illuminate\Support\Facades\DB;

class SettleAPI extends API
{
    protected $class = Settle::class;

    public static function getByItemid($itemid)
    {

    }

    public static function createSettle($param, $voidDuplicate = false) {

        if ($voidDuplicate) {
            $settle = Settle::where('settle_itemid', $param['settle_itemid'])
                ->where('settle_date', '>=',
                    substr($param['settle_date'], 0, 10).' 00:00:00')
                ->where('settle_date', '<=',
                    substr($param['settle_date'], 0, 10).' 23:59:59')
                ->get();


            if (count($settle)) {
                return $settle;
            }
        }

        return self::createModel($param, Settle::class);
    }

    public static function updateSettleStatus($settleid , $status) {
        $settle = Settle::find($settleid);
        $settle->settle_status = $status;
        $resp = $settle->save();
        if ($resp) return $settle;
        else  return 'ERROR';
    }
    public static function updateDelay($settleid) {
        $settle = Settle::find($settleid);
        $settle->settle_delay += config('W.SETTLE_DELAY');
        $resp = $settle->save();
        if ($resp) return $settle;
        else  return 'ERROR';
    }

}