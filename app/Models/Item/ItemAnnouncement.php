<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 18:20
 */

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;

class ItemAnnouncement extends Model
{
    public $timestamps = true;
    protected $table = 'item_announcement';
    protected $guarded = [];
    protected $hidden = [];
}