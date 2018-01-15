<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = true;
    protected $table = 'item';
    protected $guarded = [];
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User\User', 'userid');
    }

    public function game()
    {
        return $this->belongsTo('App\Models\Item\Game', 'item_gameid');
    }

    public function options()
    {
        return $this->hasMany('App\Models\Item\ItemOption', 'itemid');
    }

    public function announcements()
    {
        return $this->hasMany('App\Models\Item\ItemAnnouncement', 'itemid');
    }

    public function settles()
    {
        return $this->hasMany('App\Models\Operations\Settles', 'itemid');
    }

    public function userFavorites()
    {
        return $this->hasMany('App\Models\User\UserFavorite', 'itemid');
    }
}
