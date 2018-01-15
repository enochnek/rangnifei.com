<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 11:46
 */

namespace App\Models\Operator;

use Illuminate\Database\Eloquent\Model;

class Settle extends Model
{
    public $timestamps = true;
    protected $table = 'settle';
    protected $guarded = [];
    protected $hidden = [];

    public function item() {
        return $this->belongsTo('App\Models\Item\Item', 'settle_itemid');
    }
}