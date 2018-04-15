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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/api-get-player', 'PlayerController@getAll');
Route::get('/api-get-syntax', 'SyntaxController@getAll');
Route::get('/api-get-action-type', 'ActiontypeController@getAll');
//Route::get('/api-get-result-resource', 'HomeController@getNumberResultEveryDay');
Route::get('api-get-result-resource/{pubDate}', 'HomeController@getItem');

Route::get('/test', 'HomeController@test');
Route::post('/api-get-calculator-process', 'CalculatorController@index');

//Player Controller
Route::get('api-get-cash-out-by-pid/{playerId}', 'PlayerController@getCashOutByPlayerId');
Route::post('/api-modal-get-cash-out-post-id', 'PlayerController@modalGetCashOutPostId');
Route::post('/api-create-cash-out', 'PlayerController@createCashOut');


Route::get('test3', 'HomeController@test3');
