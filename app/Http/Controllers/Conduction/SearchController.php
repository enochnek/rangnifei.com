<?php

/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/10/26
 * Time: 18:30
 */
namespace App\Http\Controllers\Conduction;

use App\Http\Controllers\BaseController;
use App\Models\Item\Game;
use App\Repositories\Interfaces\SearchInterface;
use App\Services\Traits\Cacher\ConductionCacherList;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
    use ConductionCacherList;
    protected $inter;

    function __construct(SearchInterface $inter) {
        $this->inter = $inter;
    }


    // Item Search
    public function itemSearch(Request $request) {

        $data = self::readData($this, ['navbar', 'games']);
        $searchContent = $request->input('searchContent');
        if ($searchContent == '')
            return redirect('/');
        $data['items'] = $this->inter->itemSearch($searchContent);


        $data['keyword'] = $searchContent;
        return view('search', $data);

    }
 
}