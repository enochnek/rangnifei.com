<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    public $timestamps = true;
    protected $table = 'user_favorite';
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User\User', 'userid');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item\Item', 'itemid');
    }
}
