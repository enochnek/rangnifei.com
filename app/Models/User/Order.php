<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = true;
    protected $table = 'order';
    protected $guarded = [];
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User\User', 'order_userid');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item\Item', 'order_itemid');
    }

    public function option()
    {
        return $this->belongsTo('App\Models\Item\ItemOption', 'order_optionid');
    }
}
