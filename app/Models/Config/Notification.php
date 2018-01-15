<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    public $timestamps = true;
    protected $table = 'notification';

    protected $fillable = [
        'id', 'noti_status', 'noti_userid', 'noti_content', 'noti_group' ,'noti_readonly','deleted','noti_publish'
    ];
    protected $hidden = ['created_at','updated_at'];

   
}