<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class AlipayLog extends Model
{

    public $timestamps = true;
    protected $table = 'alipay_log';
    //protected $guarded = [ ;
    protected $fillable = [
        'id', 'trade_no', 'out_trade_no', 'total_amount', 'subject', 'buyer_id', 'body',
        'notify_id', 'fund_bill_list', '', 'trade_status', 'auth_app_id', 'receipt_amount', 'point_amount',
        'app_id', 'buyer_pay_amount', 'seller_id', 'gmt_create', 'gmt_payment', 'notify_time', ''
    ];
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User\User', 'userid');
    }
}