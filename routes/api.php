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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::post('goods_show', 'LoginController@goods_show');

Route::post('Price', 'LoginController@Price');

Route::post('Collection', 'CollectionController@index');

Route::post('Collshow', 'CollectionController@show');

Route::post('ads', 'AdsController@index');

Route::post('adshow', 'AdsController@show');


Route::post('default', 'AdsController@default');

Route::post('Details', 'DetailsController@index');

Route::post('Deta_adshow', 'DetailsController@deta_adshow');

Route::post('Deta_adadd', 'DetailsController@deta_adadd');

Route::post('ads_add', 'AdsController@add');

Route::post('Plus', 'CollectionController@Plus');

Route::post('Reduce', 'CollectionController@Reduce');


Route::get('pay', 'PayController@index');

Route::get('return', 'PayController@return');

Route::get('notify', 'PayController@notify');

//Route::prefix('v1.0')->group(function(){
//    Route::get('','');
//});



