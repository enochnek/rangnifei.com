<?php

namespace App\Console\Commands;

use App\Models\Item\Item;
use App\Models\Operator\Settle;
use App\Models\User\Order;
use App\Services\Operator\SettleAPI;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SettleGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SettleGenerator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $lower = date('Y-m-d H:i:s', strtotime(date('Y-m-d',time())) - 4*3600);
        $upper = date('Y-m-d H:i:s', strtotime(date('Y-m-d',time())) + 20*3600);

        $orders = Order::where('order_settle_date', '>=', $lower)
            ->where('order_settle_date', '<', $upper)->get();

//        $itemidArr = [];
//        $amountArr = [];
//        $costArr = [];
//        $array = [];
//        foreach($orders as $order) {
//
//            array_push($array['itemid'], $order->order_itemid);
//            array_push($array['amount'], $order->order_amount);
//            array_push($array['cost'], $order->order_cost);
//
//            array_push($itemidArr, $order->order_itemid);
//        }
//
//        $itemids = ['order_itemid' => function($itemid) {return $itemid;}];
        $orders = json_decode($orders, true);

        $field = [
            'order_itemid' => function($itemid) { return $itemid; }
        ];
        $value = [
            'settle_itemid' => function($itemid) {
                return $itemid[0]['order_itemid'];
            },

            'settle_sum' => function($cost) {
                return array_sum(array_column($cost, 'order_cost'));
            },

            'settle_num' => function($amount) {
                return array_sum(array_column($amount, 'order_amount'));
            },
        ];

        $data = \App\Utils\ArrayGroupBy::groupBy($orders, $field, $value);

        foreach($data as $settle) {
            $settle['settle_date'] = date('Y-m-d H:i:s', time());
            SettleAPI::createSettle($settle, 1);
        }

        return $data;

    }
}
