<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/20
 * Time: 13:45
 */

namespace App\Http\Controllers\Config;

use App\Repositories\Interfaces\NotificationInterface;
use App\Services\Config\PayAPI;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class NotificationController extends BaseController
{

    protected $inter;

    function __construct(NotificationInterface $inter)
    {
        $this->inter = $inter;
    }

    public function notification(Request $request) {

    }

    public function create(Request $request) {
        
    }

    public function delete(Request $request) {

    }

    public function update(Request $request) {

    }
}