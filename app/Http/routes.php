<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/login', 'UserController@loginPage');
Route::post('/login', 'UserController@login');

Route::get('/register', 'UserController@registerPage');
Route::post('/register', 'UserController@register');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', 'UserController@logout');
    Route::get('/', 'DashboardController@index');
});
