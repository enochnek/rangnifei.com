<?php

namespace App\Http\Middleware\Auth;

use App\Repositories\Interfaces\AuthInterface;
use App\Utils\Responsor;
use Closure;
use Illuminate\Http\Request;

class AuthCheck
{

    protected $inter;

    function __construct(AuthInterface $inter)
    {
        $this->inter = $inter;
    }

    public function handle(Request $request, Closure $next)
    {

        if ($this->checkSessionLogin($request)) {
            return $next($request);
        } else if ($this->checkSignLogin($request, $next)) {
            return $next($request);
        }
        
        //exit();
        //return $request->session()->all();
        return $this->failedAuth();
    }

    function checkSessionLogin(Request $request)
    {

        $user = $request->session()->get('user', '');
        if ($user == '') return false;

        return true;
    }

    function checkSignLogin(Request $request, Closure $next)
    {

        $userid = $request->input('userid');
        $sign = $request->input('sign');

        $resp = $this->inter->checkLogin($userid, $sign);
        if ($resp == 'OK') {
            return $next($request);
        }

        return false;
    }

    function failedAuth($resp = 'R.LOGIN_OUTDATE')
    {
        $responsor = Responsor::getInstance();

        $responsor->setStatus(config('R.LOGIN_OUTDATE'))
            ->setMessage(config('R.LOGIN_OUTDATE_MSG'));

        return redirect('login');
        //return redirect('/');
        //return response($responsor->toJson());
    }
}
