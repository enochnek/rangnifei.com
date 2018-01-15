<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = true;
    protected $table = 'user';
    protected $guarded = [];
    protected $hidden = ['password', 'remember_token'];

    public function profile()
    {
        return $this->hasOne('App\Models\User\UserProfile', 'userid');
    }
    public function verify() {
        return $this->hasOne('App\Models\User\UserVerificationConst', 'id', 'verification');
    }
}
