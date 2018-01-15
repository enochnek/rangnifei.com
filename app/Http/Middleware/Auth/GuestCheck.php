<?php

namespace App\Http\Middleware\Auth;

use Closure;

class GuestCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->session()->get('user', '');
        if ($user == '') return $next($request);
        else return redirect('/');
    }
}
