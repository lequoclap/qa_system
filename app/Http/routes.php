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
    Route::get('/', 'DashboardController@index')->name('index');

    Route::get('/me/topic', 'DashboardController@myTopics');

    Route::get('/topic/new', 'TopicController@createPage')->name('create_topic_form');
    Route::get('/topic/view/{id}', 'TopicController@viewTopic')->name('view_topic');
    Route::get('/topic/edit/{id}', 'TopicController@editPage')->name('edit_topic_form');
    Route::get('/topic/edit', 'TopicController@edit')->name('edit_topic');

    Route::post('/topic/comment', 'TopicController@commentTopic')->name('comment_topic');
    Route::post('/topic/create', 'TopicController@create')->name('create_topic');


    Route::post('/vote/create', 'VoteController@createVote');
    Route::delete('/vote/delete', 'VoteController@deleteVote');

});
