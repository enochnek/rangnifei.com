<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/25
 * Time: 11:13
 */

namespace App\Services;

use App\Utils\Format;

class  API
{
    protected $class;

    public static function getModel($id, $class = null) {

        return $class::find($id);
    }

    public static function getCount($key, $value, $class = null) {

        return $class::where($key, $value)->get()->count();
    }

    public static function createModel($param, $class = null) {

        $model = new $class;
        $model = Format::formatModel($model, $param);
        $resp = $model->save();

        if ($resp) return $model;
        return false;
    }


    // Non-Static Function
    public function getLimit($key, $value, $limit = 10, $offset = 0, $class = null) {

        if ($class == null) $class = $this->class;

        return $class::where($key, $value)
            ->offset($offset)->take($limit)->get();
    }

    public function create($param, $class = null)
    {
        if ($class == null) $class = $this->class;

        $model = new $class;
        $model = Format::formatModel($model, $param);
        $resp = $model->save();

        if ($resp) return $model;
        return false;
    }

    public function update($param, $class = null, $nonCreate = false)
    {
        if ($class == null) $class = $this->class;

        $model = $class::find($param['id']);
        if (isset($model) && $model) {

            $model = Format::formatModel($model, $param);
            $resp = $model->update();
            if ($resp) return $model;
        } else if ($nonCreate) {

            $model = new $class;
            $model = Format::formatModel($model, $param);
            $resp = $model->save();
            if ($resp) return $model;
        }

        return false;
    }

    public function delete($ids, $class = null)
    {
        if ($class == null) $class = $this->class;

        return $class::destroy($ids);
    }
}