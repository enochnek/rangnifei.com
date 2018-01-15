<?php

namespace App\Utils\Config;

class AliOSS
{

    public static $expire = 30;
    public static $dir = null;
    protected static $id = '';
    protected static $key = '';
    protected static $host = '';
    protected static $base64_policy = null;
    //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
    protected static $signature = null;
    protected static $end = null;

    public function __construct($param)
    {
        $this->id = $param['id'];
        $this->key = $param['key'];
        $this->host = $param['host'];
        $this->expire = $param['expire'];
        $this->dir = $param['dir'];
    }

    public function returnResponse()
    {
        $this->aliyunOssUploadSet();
        $response = array();
        $response['accessid'] = $this->id;
        $response['host'] = $this->host;
        $response['policy'] = $this->base64_policy;
        $response['signature'] = $this->signature;
        $response['expire'] = $this->end;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $this->dir;
        return json_encode($response);
    }

    public function aliyunOssUploadSet()
    {
        $now = time();
        $this->end = $now + $this->expire;
        $expiration = $this->gmt_iso8601($this->end);
        //最大文件大小.用户可以自己设置
        $condition = array(0 => 'content-length-range', 1 => 0, 2 => 1048576000);
        $conditions[] = $condition;
        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0 => 'starts-with', 1 => '$key', 2 => $this->dir);
        $conditions[] = $start;
        $arr = array('expiration' => $expiration, 'conditions' => $conditions);
        $policy = json_encode($arr);
        $this->base64_policy = base64_encode($policy);
        $string_to_sign = $this->base64_policy;
        $this->signature = base64_encode(hash_hmac('sha1', $string_to_sign, $this->key, true));
    }

    public function gmt_iso8601($time)
    {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration . "Z";
    }
}

?>