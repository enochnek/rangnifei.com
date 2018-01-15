<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 11:46
 */

namespace App\Models\Conduction;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public $timestamps = true;
    protected $table = 'news';
    protected $guarded = [];
    protected $hidden = [];
}