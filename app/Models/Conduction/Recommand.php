<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 11:46
 */

namespace App\Models\Conduction;

use Illuminate\Database\Eloquent\Model;

class Recommand extends Model
{
    public $timestamps = true;
    protected $table = 'recommand';
    protected $guarded = [];
    protected $hidden = [];

    public function item()
    {
        return $this->belongsTo('App\Models\Item\Item', 'recommand_itemid');
    }
}