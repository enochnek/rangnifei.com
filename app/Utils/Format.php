<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/9/28
 * Time: 20:42
 */

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;

class Format
{

    public static function formatModel(Model $model, $param) {

        foreach (array_keys($param) as $key) {
            if ($key == 'id') continue;
            if ($model->getAttribute($key) == $param[$key]) continue;

            $value = $param[$key];
            $model->setAttribute($key, $value);
        }
        return $model;
    }

    public static function filter($array, $keys, $default = null) {

        $data = null;
        foreach ($keys as $index => $key) {
            if (isset($array[$key])) {
                $data[$key] = $array[$key];
            } else if (isset($default[$index])) {
                $data[$key] = $default[$index];
            }
        }
        return $data;
    }

    public static function getAttrs($model, $keys, $isObject = false, $default = null) {

        if (is_object($model)) $model = (array) $model;
        else if ($model instanceof Model) $model = (array) json_decode($model);

        //$data = self::filter($model, $keys, $default);

        $data = [];
        foreach($keys as $index => $key) {
            $data[$key] = $model[$key];
            if (!isset($data[$key]) && isset($default[$key])) {
                $data[$key] = $default[$key];
            }
        }

        if ($isObject) return (object) $data;

        return $data;
    }

    public static function removeAttrs($model, $keys, $isObject = false) {

        if (is_object($model)) $model = (array)$model;
        else if ($model instanceof Model) {
            $model = (array) json_decode($model);
        }

        foreach ($keys as $index => $key) {
            unset($model[$key]);
        }

        if ($isObject) return (object)$model;
        else return $model;
    }

    public static function jointUrlParam($array, $isEncode = false) {

        $str = null;

        $counter = 0;
        foreach ($array as $key => $value) {

            if (!$counter) $str .= $key . '=' . $value;
            else $str .= '&' . $key . '=' . $value;

            $counter++;
        }

        if ($isEncode) return urlEncode($str);

        return $str;
    }

    // Input:       [['a', 'b', 'c'], [1, 2, 3]]
    // Output:      [['a', 1], ['b', 2], ['c', 3]]
    // Out(keys):   [['keyStr' => 'a', 'keyVal' => 1], ...]
    public static function array2dReform($array2d, $keys = null, $length = 0) {

        $hasKey = array_keys($array2d[0]);
        if (is_string($hasKey[0])) return $array2d;

        $count = count($array2d); // 2
        $length = count($array2d[0]); // 3

        $data[] = array();
        for ($i = 0; $i < $length; $i++) {
            for ($k = 0; $k < $count; $k++) {
                if ($keys && isset($keys[$k])) {
                    $data[$i][$keys[$k]] = $array2d[$k][$i];
                } else {
                    $data[$i][$k] = $array2d[$k][$i];
                }
            }
        }
        return $data;
    }
}