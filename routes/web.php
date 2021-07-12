<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/configdata', function () {
//     error_log("waarmo werk je je niet");
//     return view('configdata' );


Route::post('/createpost', 'PostsController@create')->name('post.create');
Route::get('/posts', 'PostsController@testData')->name('post.index')->middleware('auth');
Route::post('/postdelsave', 'PostsController@saveDelete')->name('post.saveDelete');





Route::get('/logs', 'LogsController@index')->name('Logs.index')->middleware('auth');
Route::post('/getlogs', 'LogsController@getlogs')->name('Logs.getLogs');




Route::get('/configdata', 'ConfigDataController@index')->name('ConfigData.index')->middleware('auth');
Route::post('/store', 'ConfigDataController@store')->name('ConfigData.store');
Route::post('/storefixed', 'ConfigDataController@storeFixed')->name('ConfigData.storeFixed');
Route::post('/storescaled', 'ConfigDataController@storeScaled')->name('ConfigData.storeScaled');
Route::post('/createnewfixed', 'ConfigDataController@createNewFixed')->name('ConfigData.createNewFixed');
Route::post('/removescaledoption','ConfigDataController@removeScaledOption')->name('ConfigData.removeScaledOption');



Route::post('/removefixedgrouporoption', 'ConfigDataController@removeFixedGroupOrOption')->name('ConfigData.removeFixedGroupOrOption');


Route::get('/', 'TimerDataController@readTimerData')->name('TimerData.readData')->middleware('auth');
Route::post('/updateSelection', 'TimerDataController@updateSelection')->name('TimerData.updateSelection');
Route::post('/startTimer', 'TimerDataController@startTimer')->name('TimerData.startTimer');



Route::post('/createpost', 'PostsController@create')->name('Post.create');



Route::get('/test', 'CreateTestLogs@test')->name('CreateTestLogs.test');





 



// Route::get('/', 'DataController@readData')->name('data.readData');
// Route::post('/data', 'DataController@store')->name('data.store');
// Route::post('/storeNewSelections', 'DataController@storeNewSelection')->name('data.storeNewSelection');
// Route::post('/storeTest', 'DataController@storeTest')->name('data.storeTest');


Auth::routes(['reset' => false, 'verify' => false,'register' => false]);

Route::get('/home', 'HomeController@index')->name('home');


