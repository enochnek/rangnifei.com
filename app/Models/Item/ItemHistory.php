<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;

class ItemHistory extends Model
{
    public $timestamps = true;
    protected $table = 'item_history';
    protected $guarded = [];
    protected $hidden = [];

}
