<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    public $timestamps = false;
    protected $table = 'user_profile';
    protected $guarded = [];
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User\User', 'userid');
    }
}
