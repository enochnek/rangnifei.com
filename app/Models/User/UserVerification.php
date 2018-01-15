<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    public $timestamps = true;
    protected $table = 'user_verification';
    protected $guarded = [];
    protected $hidden = [];

}
