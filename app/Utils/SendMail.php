<?php

namespace App\Utils;
use App\Models\Config\EmailLog;
use App\Http\Controllers\BaseController;
use App\Services\Operator\LogAPI;
use Mail;
class SendMail extends BaseController {



    public static function send($view, $param, $to, $subject) {

        Mail::send($view, $param, function($message) use ($to, $subject) {
            $message ->to($to)->subject($subject);
        });
        
        $log['username'] = $param['username'];
        $log['send_content'] = $param['content'];
        $log['email'] = $to;
        $log['send_subject'] = $subject;
        $reason = Mail::failures();
        if(count($reason)) {
            $reasonContent = '';
            foreach ($reason as $key => $value) {
                $reasonContent .= $key . ":" . $value .'。';
            }
            $log['reason'] = $reasonContent;
            LogAPI::createEmailLog($log);
        }
        return true;
    }

}