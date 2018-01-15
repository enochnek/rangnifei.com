<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserInvitation extends Model
{
    public $timestamps = false;
    protected $table = 'user_invitation';
    protected $guarded = [];
    protected $hidden = [];


}
