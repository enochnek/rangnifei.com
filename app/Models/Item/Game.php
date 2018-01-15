<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 11:46
 */

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $timestamps = false;
    protected $table = 'game';
    protected $guarded = [];
    protected $hidden = ['game_priority'];
}