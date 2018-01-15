<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 11:46
 */

namespace App\Models\Conduction;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public $timestamps = true;
    protected $table = 'banner';
    protected $guarded = [];
    protected $hidden = [];
}