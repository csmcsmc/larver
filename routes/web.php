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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/haxi', 'LoginController@haxi');

Route::get('/aaa', 'LoginController@vue');

Route::get('/fenlei', 'LoginController@fenlei');




//Route::post('/login/login_action', 'AuthController@login');

//Route::post('api/auth/me', 'AuthController@me');


//Route::get('/test', 'IndexController@index ');
//
//Route::get('/show', 'IndexController@show');
//
//Route::get('/add', 'IndexController@add');
//
//Route::get('/delete', 'IndexController@delete');
//
//Route::get('/update', 'IndexController@update');
//
//Route::get('/showa', 'IndexController@showa');
//
//Route::get('/tui', 'IndexController@tui');
//
//Route::get('/login', 'LoginController@index');
//
//Route::get('/login/login_action', 'LoginController@login_action');


