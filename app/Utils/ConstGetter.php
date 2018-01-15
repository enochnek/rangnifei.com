<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/27
 * Time: 16:19
 */

namespace App\Utils;


use Illuminate\Support\Facades\DB;

class ConstGetter
{
    protected static $instance;
    public $constArray = [];
    protected $tables = ['user_verification_const', 'user_relation_const'];

    function __construct()
    {
        $this->loadDB();
    }

    public function loadDB($table = null)
    {

        if (!$table) {

            foreach ($this->tables as $t) {
                $data = json_decode(DB::table($t)->get());
                foreach ($data as $c) {
                    $this->constArray[$t][$c->id] = $c;
                }
            }
        } else {

            $data = json_decode(DB::table($table)->get());
            foreach ($data as $c) {
                $this->constArray[$table][$c->id] = $c;
            }
        }
        return $this;
    }

    public static function get($table, $id)
    {
        $getter = ConstGetter::getInstance();
        return $getter->getConst($table, $id);
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConst($table, $id)
    {
        return $this->constArray[$table][$id];
    }
}