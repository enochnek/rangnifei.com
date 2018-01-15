<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '/v1', 'middleware' => ['cors']], function () {

    // User API
    Route::group(['namespace' => 'User'], function () {

        // Register & Login
        Route::post('register/sendRegisterSMS', 'RegisterController@sendRegisterSMS');
        Route::post('register', 'RegisterController@register');

        Route::post('resetPass/sendRegisterSMS', 'ResetPassController@sendRegisterSMS');
        Route::post('resetPass', 'ResetPassController@resetPass');

        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout');
        Route::post('checkLogin', 'LoginController@checkLogin');
        Route::post('verify', 'VertificationController@create');


        //
        Route::group(['prefix' => '/user'], function() {

            Route::post('getUserInfo', 'UserController@getUserInfo');
            Route::post('getMyOrders', 'UserController@getMyOrders');
            Route::post('getMyItems', 'UserController@getMyItems');

            Route::group(['prefix' => '/profile'], function() {
                //Route::post('update', 'UserProfileController@update');
            });

            Route::group(['prefix' => '/order'], function() {
                Route::post('create','UserOrderController@create');
            });
            Route::group(['prefix' => '/item'], function() {
                Route::post('fav', 'UserFavoriteController@favorite');
                Route::post('unfav', 'UserFavoriteController@unFavorite');
            });
        });

    });
    Route::group(['namespace' => 'PageAdmin'], function() {
        Route::post('balanceSettle', 'AdminController@balanceSettle');
        Route::post('delay', 'AdminController@delay');
        Route::post('reject', 'AdminController@reject');
    });


    Route::group(['namespace' => 'Item', 'prefix' => '/item'], function () {
        Route::post('create', 'ItemController@create');
        Route::post('update', 'ItemController@update');
        Route::post('getAnnouncements', 'ItemController@getAnnouncements');
        Route::post('createAnnouncement', 'ItemController@createAnnouncement');


        Route::get('getGames', 'ItemController@getGames');
        Route::get('getOrderedItems', 'ItemController@getOrderedItems');
        Route::post('getItemInfo', 'ItemController@getItemInfo');
        Route::post('getComments', 'ItemCommentController@getComments');
        Route::post('createComment', 'ItemController@createComment');


    });

    Route::group(['namespace' => 'Config'], function () {
        Route::post('getOssSign', 'WebConfigController@getOssSign');


        Route::post('pay', 'PayController@pay');
        Route::post('payment/alipay/asynSuccess', 'PayController@asynSuccess');
        Route::get('payment/alipay/sychronizedSuccess', 'PayController@sychronizedSuccess');
    });
     Route::group(['namespace' => 'Conduction'], function() {
         Route::get('getConductions', 'ConductionController@getConductions');
         Route::post('createNews', 'NewsController@createNews');
         Route::post('getNews', 'NewsController@getNews');


    });
});