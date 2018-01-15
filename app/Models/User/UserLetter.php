<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserLetter extends Model
{
	
 	public $timestamps = true;
    protected $table = 'user_letter';
    protected $fillable = [
        'id', 'source_userid', 'target_userid', 'title', 'content', 'is_read'
    ];
    protected $hidden = [];

}
