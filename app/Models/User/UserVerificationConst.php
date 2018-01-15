<?php

namespace App\models\user;

use Illuminate\Database\Eloquent\Model;

class UserVerificationConst extends Model
{
    public $timestamps = true;
    protected $table = 'user_verification_const';
    protected $guarded = [];
    protected $hidden = [];

}
