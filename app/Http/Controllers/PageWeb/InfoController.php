<?php

namespace App\Http\Controllers\PageWeb;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Item\ItemCommentController;
use App\Http\Requests\Item\CommentCreateRequest;
use App\Http\Requests\User\PayRequest;
use App\Models\Item\Item;
use App\Models\Item\ItemComment;
use App\Models\Item\ItemOption;
use App\Repositories\Interfaces\ItemHandleInterface;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\Interfaces\PayInterface;
use App\Repositories\Interfaces\UserHandleInterface;
use App\Services\API;
use App\Services\Item\ItemAPI;
use App\Services\Item\ItemHandleAPI;
use App\Services\User\UserAPI;
use App\Utils\Format;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;

class InfoController extends BaseController {

    private $inter;

    function __construct(ItemInterface $inter) {
        $this->inter = $inter;
    }

    public function index(Request $request, $itemid) {

        $data['itemInfo'] = $this->inter->getcItemInfo($itemid);
        $data['isFavorite'] = 0;
        $data['self'] = 0;
        if ($request->session()->get('user')) {
            $data['isFavorite'] = UserAPI::isFavorite($request->session()->get('user')->id, $itemid);
            $userid = API::getModel($itemid,Item::class)->userid;
            if ($userid == $request->session()->get('user')->id)
                $data['self'] = 1;
        }
        return view('info', $data);
    }

    public function comments(Request $request, $itemid) {

        $temp = Format::filter($request->all(), ['page', 'limit'], [1, 10]);
        $page = $temp['page'];
        $limit = $temp['limit'];

        $offset = ($page-1) * $limit;

        $comments = $this->inter->getComments($itemid, $limit, $offset);

        $data['comments'] = $comments;

        $count = ItemComment::where('itemid', $itemid)->where('parent', 0)->get()->count();
        $param['total'] = (int) ($count/$limit + 1);
        $param['count'] = $count;
        $param['page'] = $page;

        $data['pager'] = (object) $param;
        if($request->session()->get('user'))
            $uid = $request->session()->get('user')->id;
        else
            $uid = 0;

        $data['pay'] = UserAPI::getItemOrderIds($itemid, $uid)->count();
        // Self Item Can Publish comment
        $is = self::isBelongs($uid, 'userid', $itemid, Item::class);
        if (!$data['pay'] && $is) $data['pay'] = 1;
        $data['itemid'] = $itemid;
        return Response::view('info.comments', $data);
    }

    public function buy(Request $request, $itemid) {

        $item = $this->inter->getcItemInfo($itemid);
        $data['options'] = (array) $item->options;
        $data['note'] = $item->item_note;
        $data['options'] = (array_values($data['options']));
        return view('buy', $data);
    }

    public function checkPay(Request $request, $itemid) {
        $isFake = ItemAPI::isFake($itemid);

        // if ($isFake) return self::responseMsgCode('IS_FAKE');

        $itemStatus = ItemAPI::getItemStatas($itemid);
        if (!in_array($itemStatus,config('W.ITEM_CAN_STATUS')))
            return self::responseMsgCode('IS_FAKE');

        $optionid = $request->input('optionid');
        $data['amount'] = $request->input('amount');
        $money = $request->input('money');
        if ($optionid <= 0) {
            $optionid = 0;
            $data['title'] = '直接赞助';
            $data['cost'] = $money  * $data['amount'];
            $data['singleCost'] = $money;
            if ($money == 0) return self::responseMsgCode('PAY_INT');
        }else{
            $option = API::getModel($optionid,ItemOption::class);
            $data['singleCost'] = $option->item_option_cost;
            $data['title'] = $option->item_option_title;
            $data['cost'] = $option->item_option_cost  * $data['amount'];
        }
        $data['optionid'] = $optionid;

        $data['note'] = $request->input('note');
        $uid = $request->session()->get('user')->id;
        $data['balance'] = UserAPI::getUserBalance($uid);
        Cookie::queue('url', url('/' . $itemid), 60, null, null, false, false, false, null);
        return view('info/checkpay', $data);
    }

    public function pay(PayRequest $request, $itemid, $method, PayInterface $inter, UserHandleInterface $userInter) {
        if (self::hasRequestError($request)) {
            return self::responseRequestError($request);
        }
        $singleCost = $request->input('singleCost');
        $amount = $request->input('amount');
        $optionid = intval($request->input('optionid'));
        $note = $request->input('note');
        if ($optionid <= 0) {
            $optionid = 0;
            $optionTitle = '直接赞助';
            $cost = $singleCost * $amount;
        } else {
            $option = UserAPI::getModel($optionid, ItemOption::class);
            $optionTitle = $option->item_option_title;
            $cost = $option->item_option_cost * $amount;
        }
        if ($cost == 0) {
            return redirect(url()->previous());
        }

        $userid = $request->session()->get('user')->id;
        switch ($method) {
            case 'alipay':
                $param = ['total_amount' => $cost,
                    'subject' => '让你飞比赛网 - 赞助 ' . $cost . ' 元',
                    'body' => '(' . $amount . '个) ' . $optionTitle,
                    'timeout_express' => '1c',
                    'goods_type' => 0];

                $extra = Format::jointUrlParam(["order_userid" => $userid, "order_itemid" => $itemid, "order_optionid" => $optionid,
                    "order_amount" => $amount, "order_cost" => $cost, "top" => 0,"order_note" => $note], true);
                $html = $inter->set('http://www.rangnifei.com/successPayment')->alipay($param, $extra);
                $cookie = Cookie::make('url', url('/' . $itemid), 60, null, null, false, false, false, null);
                return Response::make($html)->withCookie($cookie);
            case 'wechat':
                break;
            case 'balance':
                $verifyBalance = UserAPI::checkBalance($userid,$cost);

                if (!$verifyBalance)  return self::responseMsgCode('ERROR');
                $consumeResp = $userInter->balancePay("项目赞助", $userid, $cost , 1);
                $param['order_itemid'] = $itemid;
                $param['order_optionid'] = $optionid;
                $param['order_amount'] = $amount;
                $param['order_note'] = $note;
                $param['order_cost'] = $cost;

                if (self::isErrorMsg($consumeResp)) return self::responseMsgCode($consumeResp);
                else $orderResp = $userInter->createOrder($param, $userid , 1);

                if (self::isErrorMsg($orderResp)) return self::responseMsgCode($orderResp);
                return view('redirect');

        }

    }

    public function history(Request $request, $itemid) {

        $histories = ItemAPI::getHistory($itemid);

        $data['histories'] = $histories;
        return Response::view('info.history', $data);
    }

}
