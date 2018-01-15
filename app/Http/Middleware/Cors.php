<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/9/15
 * Time: 13:51
 */

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

error_reporting(E_ERROR | E_WARNING | E_PARSE);
use Closure;

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        date_default_timezone_set('Asia/Shanghai');
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
        $response->header('Access-Control-Allow-Credentials', 'true');

        $currentDomain = $_SERVER['HTTP_HOST'];
        $requestDomain = $request->input('domain');

        if ($currentDomain != $requestDomain) {
            //return  response()->json(['error'=>config('R.UNAUTHORIZED_MSG')],config('R.UNAUTHORIZED'));
        }
        return $response;
    }
}