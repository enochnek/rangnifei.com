<?php

namespace App\Http\Controllers\PageWeb;

use App\Http\Controllers\BaseController;
use App\Repositories\Interfaces\PayInterface;
use Illuminate\Http\Request;

class SuccessController extends BaseController
{
    public function successPayment(Request $request, PayInterface $inter)
    {
        $resp = $inter->sychronized($request->all());

        if (!$resp) {

            return 'error';
        } else {

            return view('redirect');
        }
    }
}
