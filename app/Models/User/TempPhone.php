<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 11:15
 */

namespace App\models\user;

use Illuminate\Database\Eloquent\Model;

class TempPhone extends Model
{
    public $timestamps = true;
    protected $table = 'temp_phone';
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User\User', 'phone', 'phone');
    }
}