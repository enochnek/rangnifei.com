<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 11:45
 */

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;

class ItemOption extends Model
{
    public $timestamps = false;
    protected $table = 'item_option';
    protected $guarded = [];
    protected $hidden = [];
}