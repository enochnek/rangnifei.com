<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['namespace' => 'PageWeb', 'middleware' => ['web']], function () {

    Route::get('/', 'IndexController@index');
    Route::get('/packet/{price}/{userid}', 'IndexController@redPacket')->where('price','^[0-9]+(.[0-9]{1,2})?$')->where('userid','[0-9]+');
    Route::get('/about/{index}', 'IndexController@foot');
    Route::get('/u/{userid}', 'IndexController@user')->where('userid', '[0-9]+');
    Route::get('/game/{gameid}', 'IndexController@game')->where('gameid', '[0-9]+');
    Route::get('/{itemid}', 'InfoController@index')->where('itemid', '[0-9]+');
    Route::get('/{itemid}/info', 'InfoController@index')->where('itemid', '[0-9]+');
    Route::post('/{itemid}/comments', 'InfoController@comments')->where('itemid', '[0-9]+');
    Route::post('/{itemid}/history', 'InfoController@history')->where('itemid', '[0-9]+');

    // Users' Surfaces
    Route::group(['middleware' => ['auth.logincheck']], function () {
        Route::get('logout', 'IndexController@logout');

        Route::get('/{itemid}/buy', 'InfoController@buy')->where('itemid', '[0-9]+');
        Route::post('/{itemid}/buy/checkpay', 'InfoController@checkpay')->where('itemid', '[0-9]+');
        Route::get('/{itemid}/pay/{method}', 'InfoController@pay')->where('itemid', '[0-9]+');;

        Route::post('/{itemid}/createComment', 'InfoDataController@createComment')->where('itemid', '[0-9]+');
        Route::post('/{itemid}/fav', 'InfoDataController@fav')->where('itemid', '[0-9]+');
        Route::post('/{itemid}/unfav', 'InfoDataController@unfav')->where('itemid', '[0-9]+');
    });

    Route::get('/{itemid}/{data?}', 'InfoController@index')->where('itemid', '[0-9]+');

    // Guests' Surfaces
    Route::group(['middleware' => ['auth.guestcheck']], function () {
        Route::get('register', 'IndexController@register');
        Route::get('register/{inviterid?}', 'IndexController@registerInvite');
        Route::get('login', 'IndexController@login');
        Route::get('resetpass', 'IndexController@resetpass');
    });

    // User Backend
    Route::group(['middleware' => ['auth.logincheck']], function () {
        Route::get('backend', 'BackendController@index');
        Route::get('/backend/publish', 'BackendController@publish');
        Route::post('/backend/orders', 'BackendController@orders');

        Route::post('/backend/myitems', 'BackendController@myItems');
        Route::post('/backend/messages', 'BackendController@messages');
        Route::post('/backend/verify', 'BackendController@verify');
        Route::post('/backend/settles', 'BackendController@settles');
        Route::post('/backend/announcements', 'BackendController@announcements');
        Route::post('/backend/sponsors', 'BackendController@sponsors');
        Route::post('/backend/uploadAvatar', 'BackendController@uploadAvatar');

        Route::post('/backend/profile', 'BackendController@profile');
        Route::post('/backend/favorites', 'BackendController@favorites');
        Route::get('/backend/{data?}', 'BackendController@index');
        Route::get('/edit/{itemid}', 'BackendController@edit')->where('itemid', '[0-9]+');

        Route::get('/backend/downItemPartakeInfo/{itemid}', 'BackendController@downLoadPartakeInfo')->where('itemid', '[0-9]+');

        Route::post('/backend/createItem', 'BackendDataController@createItem')->where('itemid', '[0-9]+');
        Route::post('/edit/update', 'BackendDataController@updateItem')->where('itemid', '[0-9]+');
        Route::post('/backend/endItem', 'BackendDataController@endItem');
        Route::post('/backend/showItemStatus', 'BackendController@showItemStatus');

        Route::post('/backend/getAnnouncements', 'BackendDataController@getAnnouncements');
        Route::post('/backend/createAnnouncement', 'BackendDataController@createAnnouncement');
        Route::post('/backend/updateProfile', 'BackendDataController@updateProfile');

        Route::get('successPayment', 'SuccessController@successPayment');
    });
});


Route::group(['namespace' => 'PageAdmin', 'middleware' => ['web']], function () {

    // Users' Surfaces
    Route::group(['middleware' => ['auth.logincheck', 'auth.admincheck']], function () {
        Route::get('/admin', 'AdminController@index');
    });

});

Route::group(['namespace' => 'Config', 'middleware' => ['web']], function () {
    Route::get('alipay', 'PayController@alipay');
    Route::get('sychronized', 'PayController@sychronized');
    Route::post('aysn', 'PayController@aysn');
});

// Search
Route::group(['namespace' => 'Conduction', 'middleware' => ['web']], function () {

    Route::get('itemSearch', 'SearchController@itemSearch');
});

Route::get('test', 'testController@test');