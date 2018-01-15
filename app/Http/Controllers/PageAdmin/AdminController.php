<?php

namespace App\Http\Controllers\PageAdmin;

use App\Http\Controllers\BaseController;
use App\Models\Item\Item;
use App\Models\Operator\Settle;
use App\Repositories\Interfaces\UserHandleInterface;
use App\Services\API;
use App\Services\Operator\SettleAPI;
use App\Services\User\UserHandleAPI;
use App\Utils\Format;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    public function index() {

        $nowHour = date('H', time());

        if ($nowHour < 20) {

            $lower = strtotime(date('Y-m-d', time() - 86400)) - 4 * 3600;
            $upper = strtotime(date('Y-m-d', time() - 86400)) + 20 * 3600;
        } else {

            $lower = strtotime(date('Y-m-d', time())) - 4 * 3600;
            $upper = strtotime(date('Y-m-d', time())) + 20 * 3600;
        }


        $settles = Settle::where('settle_status', '!=', '1')
            ->where('settle_date', '<', date('Y-m-d H:i:s',$upper-86400))->get();
//        foreach($settles)

        $settles2 = Settle::where('updated_at', '>=', date('Y-m-d H:i:s', $lower))
            ->where('settle_date', '<', date('Y-m-d H:i:s',$upper))->get();

        $settles = $settles->merge($settles2);

        foreach($settles as $index => $settle) {
            $item = $settle->item;
            $user = $settle->item->user;

            unset($settles[$index]->item);
            $settles[$index]->item = Format::getAttrs(json_decode($item),
                ['item_title'], true);

            unset($settles[$index]->user);
            $settles[$index]->user = Format::getAttrs(json_decode($user),
                ['username', 'phone', 'verification','id'], true);

            $settles[$index]->settle_status_name =
                config('W.SETTLE_STATUS_' . $settle->settle_status);


        }

        $data['settles'] = json_decode($settles);

        return view('admin.index', $data);
    }
    public function balanceSettle(Request $request, UserHandleInterface $inter) {
        $settleid = $request->input('settleid');
        $userid = $request->input('userid');
        $resp = SettleAPI::updateSettleStatus($settleid, config("W.SETTLE_STATUS_1_CODE"));
        if ($resp) {
            $item = API::getModel($resp->settle_itemid,Item::class);
            $param['content'] = "你的项目id:" . $item->id . ",标题: '"
                . $item->item_title ."' 结算成功. 结算金额为:" . $resp->settle_sum . "元. 请打开支付宝查看...";
            $param['title'] = "结算成功...";
            $newResp = $inter->createNotice($param,$userid);

            if ($newResp) return self::responseMsgCode('OK');
        }
        return self::responseMsgCode('ERROR');
    }

    public function delay(Request $request, UserHandleInterface $inter) {
        $settleid = $request->input('settleid');
        $userid = $request->input('userid');
        $respStatus = SettleAPI::updateSettleStatus($settleid, config("W.SETTLE_STATUS_2_CODE"));
        $respDelay = SettleAPI::updateDelay($settleid);
        if ($respStatus && $respDelay) {
            $item = API::getModel($respStatus->settle_itemid, Item::class);
            $param['content'] = "你的项目id:" . $item->id . ",标题: '"
                . $item->item_title . "' 结算被推迟 " . config('W.SETTLE_DELAY') . "天.";
            $param['title'] = "推迟结算...";
            $newResp = $inter->createNotice($param, $userid);
            if ($newResp) return self::responseMsgCode('OK');
        }
        return self::responseMsgCode('ERROR');
    }

    public function reject(Request $request, UserHandleInterface $inter) {
        $settleid = $request->input('settleid');
        $userid = $request->input('userid');
        $resp = SettleAPI::updateSettleStatus($settleid, config("W.SETTLE_STATUS_4_CODE"));
        if ($resp) {
            $item = API::getModel($resp->settle_itemid,Item::class);
            $param['content'] = "你的项目id:" . $item->id . ",标题: '"
                . $item->item_title ."' 今日结算已被驳回...,详情请联系管理员.";
            $param['title'] = "驳回结算...";
            $newResp = $inter->createNotice($param,$userid);

            if ($newResp) return self::responseMsgCode('OK');
        }
        return self::responseMsgCode('ERROR');
    }
}
