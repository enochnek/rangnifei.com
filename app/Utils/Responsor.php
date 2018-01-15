<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 10:16
 */

namespace App\Utils;

class Responsor
{
    private static $instance;
    private $status;
    private $message;
    private $data;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function Error()
    {

    }

    public static function Success()
    {

    }

    public function toJson()
    {
        $json['status'] = $this->status;
        $json['message'] = $this->message;

        if ($this->data != null)
            $json['data'] = $this->data;

        //return json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    private function __clone()
    {
    }

}