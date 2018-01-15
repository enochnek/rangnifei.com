<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{

    public $timestamps = true;
    protected $table = 'email_log';
    protected $fillable = [
        'id', 'username', 'email', 'send_subject', 'send_content', 'reason'
    ];
    protected $hidden = [];

    
}