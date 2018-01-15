<?php

namespace App\Http\Controllers\PageWeb;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\User\LoginController;
use App\Models\Item\Game;
use App\Models\Item\Item;
use App\Repositories\Interfaces\ConductionInterface;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Services\API;
use App\Services\Item\ItemAPI;
use App\Services\Traits\Cacher\ConductionCacherList;
use App\Utils\Format;
use App\Models\User\User;
use Illuminate\Http\Request;

class IndexController extends BaseController
{


    use ConductionCacherList;

    public function index(ItemInterface $inter, ConductionInterface $interConduction) {
	
        // Straight to read laravel cacher
        $data = self::readData($this, ['navbar', 'banners', 'advers', 'games']);
	

        // Get top 4 games of items
        for ($i = 0; $i < 4; $i++) {
            $data['orderedItems'][$i] = $inter->getcOrderedItems($i + 1, 8);
        }
	
        // Get recommand items limit 4
        $data['recommandItems'] = $interConduction->getcWebRecommandItems();


        return view('index', $data);
    }

    public function register() {
        return view('register');
    }
    
    public function redPacket(Request $request, $price,$userid) {
        $param['price'] = $price;
        $param['userid'] = $userid;
        return view('gift',$param);
    }
    
    public function registerInvite(Request $request, $inviterId) {
		
		$data = [];
		if (isset($inviterId)) {
			if ($inviterId > 0) $data['inviterId'] = $inviterId;
		}
			
        return view('register', $data);
        //return view('register');
    }

    public function login() {

        return view('login');
    }

    public function resetpass() {

        return view('resetpass');
    }

    public function logout(Request $request) {

        $controller = new LoginController();

        $resp = $controller->logout($request);
        return back();
    }

    public function search(Request $request) {

        return view('list');
    }

    public function game(Request $request, $gameid, ItemInterface $inter) {

        $page = $request->input('page');

        $data = self::readData($this, ['navbar', 'games']);

        //$data['items'] = $inter->getcOrderedItems($gameid, 32);

        $p = Format::filter($request->all(), ['page', 'limit'], [1, 16]);
        $page = $p['page'];
        $limit = $p['limit'];
        $offset = ($page-1) * $limit;

        $itemids = ItemAPI::getOrdered($gameid, $limit, $offset, ['id']);
        $items = null;
        foreach($itemids as $index => $itemid) {
            $items[$index] = $inter->getcItem($itemid->id);
        }

        $param['count'] = Item::where('item_gameid', $gameid)->get()->count();
        $param['total'] = (int) ($param['count']/$limit + 1);
        $param['page'] = $page;

        $data['pager'] = (object) $param;
        $data['items'] = $items;

        $data['keyword'] = API::getModel($gameid, Game::class)->game_name;
        $data['gameid'] = $gameid;
        $ico = (Game::where('id', $gameid)->first(['game_iconurl']));

        $data['gameicon'] = $ico->game_iconurl;
        //dd($data);
        return view('list', $data);
    }

    public function foot(Request $request, $index) {

        $data['title'] = config('P.ABOUT_'.strtoupper($index).'_TITLE');
        $data['quote'] = config('P.ABOUT_'.strtoupper($index).'_QUOTE');
        $data['paragraph'] = config('P.ABOUT_'.strtoupper($index).'_PARAGRAPH');
        return view('foot', $data);
    }
    public function user(Request $request, $userid, UserInterface $inter) {

        // Get User's Publish Items
        $orders = $inter->getMyItems($userid,999,0);
        $data['items'] = (object) $orders;
        $data['count']= count($orders);

        // Get User's Infomations
        $user = User::find($userid);
        $profile['avatar'] = $user->profile->avatar;
        $profile['introduction'] = $user->profile->introduction;
        $profile['sex'] = $user->profile->sex;
        $profile['qq'] = $user->profile->qq;
        $data['user']['username'] = $user->username;
        $data['user']['username'] = $user->username;
        $data['user']['id'] = $user->id;
        $data['user']['verification'] = $user->verification;
        $data['user']['level'] = $user->level;

        // Merge Array To Object
        $data['user']['profile'] =  $profile;
        $data['user']['profile'] = (object) $data['user']['profile'];
        $data['user'] = (object) $data['user'];
        return view('user', $data);
    }
}
