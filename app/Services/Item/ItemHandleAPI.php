<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 11:38
 */

namespace App\Services\Item;

use App\Models\Item\Item;
use App\Models\Item\ItemAnnouncement;
use App\Models\Item\ItemComment;
use App\Models\Item\ItemOption;

class ItemHandleAPI extends ItemAPI
{
    protected $class = Item::class;

    public static function createItem($param, $options = null) {

        $api = new self();
        $resp = $api->create($param);
        if ($resp && $options) {
            $itemid = $resp->id;

            foreach($options as $index => $option) {
                $options[$index]['itemid'] = $itemid;
            }

            ItemOption::insert($options);
        }
        return $resp;
    }
    public static function updateItem($param, $newOptions = null, $originIds = null) {

        $itemid = $param['id'];

        $afterIds = [];

        $api = new self();
        $resp = $api->update($param);
        if ($resp && $newOptions) {

            for ($i = 0; $i < count($newOptions); $i++) {

                if (isset($newOptions[$i]['id']) && $newOptions[$i]['id']) {

                    array_push($afterIds, $newOptions[$i]['id']);
                    $api->update($newOptions[$i], ItemOption::class);
                } else {

                    $newOptions[$i]['itemid'] = $itemid;
                    $api->create($newOptions[$i], ItemOption::class);
                }
            }
        }

        if (is_array($originIds)) {

            $diffIds = array_diff($originIds, $afterIds);

            $array = null;
            foreach($diffIds as $diffId) {
                $array['id'] = $diffId;
                $array['item_option_unavailable'] = 1;
                $api->update($array, ItemOption::class);
            }
        }
        return $resp;
    }

    public static function createComment($param) {

        return self::createModel($param, ItemComment::class);
    }

    public static function createAnnouncement($param) {

        return self::createModel($param, ItemAnnouncement::class);
    }
}