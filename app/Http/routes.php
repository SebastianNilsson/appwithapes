<?php
Route::get('/login', ['as' => 'login', 'uses' => 'SteamController@login']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'SteamController@logout']);
Route::get('/', ['as' => 'index', 'uses' => 'Games@index']);
Route::get('/about', ['as' => 'about', 'uses' => 'Pages@about']);
Route::get('/shop', 'Pages@shop');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/newgame', 'Games@newgame');
    Route::post('/chat', ['as' => 'chat', 'uses' => 'ChatController@add_message']);
    Route::get('/chats', ['as' => 'chat', 'uses' => 'ChatController@add_message']);
    Route::post('/save_link', ['as' => 'settings.update', 'uses' => 'SteamController@updateSettings']);
    Route::match(['get', 'post'], '/newbet', ['as' => 'newbet', 'uses' => 'Games@newbet']);
    Route::get('/setGameStatus', 'Games@setGameStatus');
    Route::post('/getBalance', ['as' => 'get.balance', 'uses' => 'Games@getBalance']);
});

Route::group(['middleware' => 'auth', 'middleware' => 'access:admin'], function () {
    Route::get('/newBet', 'Games@newBetinapi');
    Route::match(['get', 'post'],'/fast', 'Fast@index');
    Route::match(['get', 'post'], '/chatdel', ['as' => 'chat', 'uses' => 'ChatController@delete_message']);
});

Route::group(['prefix' => 'api', 'middleware' => 'secretKey'], function () {
    Route::post('/newGame', 'Games@newgame');
    Route::get('/newBet', 'Games@newBetinapi');
    Route::post('/setGameStatus', 'Games@setGameStatus');
    Route::post('/getCurrentGame', 'Games@getCurrentGame');
    Route::post('/getWinners', 'Games@getWinners');
    Route::post('/setItemStatus', 'Games@setItemStatus');
});
