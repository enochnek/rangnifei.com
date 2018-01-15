<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 20:27
 */

namespace App\Services\Conduction;

use App\Models\Conduction\Recommand;
use App\Services\API;

class RecommandAPI extends API
{
    protected $class = Recommand::class;

    public static function getItemids($group = 0, $limit = 4)
    {

        if ($group) {
            $itemids = Recommand::where('recommand_group', $group)
                ->orderBy('recommand_priority', 'desc')
                ->orderBy('created_at', 'desc')
                ->take($limit)->get(['recommand_itemid']);

        } else {
            $itemids = Recommand::orderBy('recommand_priority', 'desc')
                ->orderBy('created_at', 'desc')
                ->take($limit)->get(['recommand_itemid']);

        }

        foreach ($itemids as $index => $itemid) {
            $itemids[$index] = $itemid->recommand_itemid;
        }
        return $itemids;
    }
}