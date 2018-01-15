<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;

class ItemComment extends Model
{

    public $timestamps = true;
    protected $table = 'item_comment';
    protected $fillable = [
        'id', 'itemid', 'userid', 'item_comment_content','parent'
    ];
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User\User', 'userid');
    }

    public function userProfile()
    {
        return $this->belongsTo('App\Models\User\UserProfile', 'userid', 'userid');
    }

    public function children() {
        return $this->hasMany('App\Models\Item\ItemComment', 'parent');
    }
}
