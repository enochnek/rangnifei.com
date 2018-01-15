<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Item\ItemUpdateRequest;
use App\Services\Traits\ResponseTool;
use App\Utils\CacherReader;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class BaseController extends Controller
{
    use ResponseTool;
//
//    public static function responseCookie($key, $value, $expire = 60) {
//
//        $cookie = Cookie::make($key, $value, $expire);
//        $response = new Response();
//        return $response->withCookie($cookie);
//    }

    protected static function isErrorMsg($resp) {

        if (is_string($resp)) {
            $msg = config('R.' . $resp);
            if (!isset($msg) || $msg != 0) {
                return true;
            }
        }

        if ($resp == false) return true;

        return false;
    }

    protected static function newRequest(Request $request, $param = null,
                                         $requestClass = null) {

        if (!$requestClass) $requestClass = Request::class;

        if (!isset($param)) {
            $param = $request->all();
        }



        //$newRequest = new $requestClass();
        //$newRequest->create($request->url(), $request->method(), $param);
        //$newRequest->setContainer(Container::getInstance());
        //return $newRequest;

        $newRequest = $requestClass::create($request->url(), $request->method(), $param);
        return $newRequest;
    }

    protected static function hasRequestError(BaseRequest $request) {

        if ($request->getErrorsCount()) return true;
        return false;
    }

    protected static function catchRequestErrors(BaseRequest $request) {

        if ($request->getErrorsCount()) {
            return $request->getErrors();
        } else {
            return null;
        }
    }

    protected static function readData($from, $keys, $argv = null, $notArray = 0) {

        $reader = new CacherReader();

        $param = null;
        if (is_array($keys)) {
            foreach ($keys as $key) {
                $param[$key] = $reader->from($from)->get($key, $argv);
            }
        } else {
            if ($notArray) $param = $reader->get($keys, $argv);
            else $param[$keys] = $reader->from($from)->get($keys, $argv);
        }
        return $param;
    }

    protected static function downloadFile($content, $filenmae) {
            
        $response = new Response($content);
        return $response->header('Content-Type', 'application/txt')
                        ->header('Content-Disposition: attachment;filename=', $filenmae);

    }

    protected static function isBelongs($checkId, $checkKey, $targetId, $class) {

        $target = $class::find($targetId);
        $attr = $target->getAttribute($checkKey);
        if ($checkId == $attr) return true;

        return false;
    }
}
