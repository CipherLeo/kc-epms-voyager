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


Route::group(['prefix' => 'admin'], function () {
    
    Route::get('pr-trackers/{id}', ['as' => 'voyager.pr-trackers.show', 'uses' => 'PrTrackerController@show'])->where('id', '[0-9]+');

    Voyager::routes();

    //Route:resource('pr-trackers', 'PrTrackerController');

    // CUSTOM ROUTES
    Route::get('pr-trackers/create', ['as' => 'voyager.pr-trackers.create', 'uses' => 'PrTrackerController@create']);
    Route::post('pr-trackers', ['as' => 'voyager.pr-trackers.store', 'uses' => 'PrTrackerController@store']);
});