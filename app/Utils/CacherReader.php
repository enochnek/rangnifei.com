<?php

namespace App\Utils;

class CacherReader
{

    private $class;

    function __construct($class = null)
    {
        $this->class = $class;
    }

    public function from($class)
    {
        $this->class = $class;
        return $this;
    }

    public function get($key, $argv = null, $class = null, $default = null)
    {
        $funcName = $key;

        if ($class && class_exists($class)) {
            $ref = new \ReflectionClass($class);
            $inst = $ref->newInstanceArgs();
            if (method_exists($inst, $funcName)) {
                $func = new \ReflectionMethod($inst, $funcName);
                $func->setAccessible(true);
                return $func->invoke($inst, $argv);
            }
        } else {
            $class = $this->class;
            if (method_exists($class, $funcName)) {
                $func = new \ReflectionMethod($class, $funcName);
                $func->setAccessible(true);
                return $func->invoke($class, $argv);
            }
        }
        return $default;
    }
}