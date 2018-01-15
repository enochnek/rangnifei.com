<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Consume extends Model
{
    public $timestamps = true;
    protected $table = 'consume_log';
    protected $guarded = [];
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User\User', 'userid');
    }

}
