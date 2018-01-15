<?php

namespace App\Http\Middleware\Auth;

use App\Models\User\User;
use App\Repositories\Interfaces\AuthInterface;
use Closure;
use Illuminate\Http\Request;

class AdminCheck
{

    protected $inter;

    function __construct(AuthInterface $inter)
    {
        $this->inter = $inter;
    }

    public function handle(Request $request, Closure $next) {

        $user = $request->session()->get('user');

        if (!$user) return redirect('/');

        $isAdmin = User::find($user->id)->admin;
        if (!$isAdmin) return redirect('/');

        return $next($request);
    }
}
