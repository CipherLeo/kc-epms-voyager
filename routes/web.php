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
    
    Route::get('pr-trackers/{pr_tracker}/edit ', ['as' => 'voyager.pr-trackers.edit', 'uses' => 'PrTrackerController@edit']);

    Voyager::routes();

    // CUSTOM ROUTES
    // PR-TRACKERS
    Route::get('pr-trackers/{pr_tracker}', ['as' => 'voyager.pr-trackers.show', 'uses' => 'PrTrackerController@show']);
    Route::get('pr-trackers/create', ['as' => 'voyager.pr-trackers.create', 'uses' => 'PrTrackerController@create']);
    Route::post('pr-trackers', ['as' => 'voyager.pr-trackers.store', 'uses' => 'PrTrackerController@store']);

    // Supplemental Request
    Route::post('supplemental-requests', ['as' => 'voyager.supplemental-requests.store', 'uses' => 'SupplementalRequestController@store']);
    Route::delete('supplemental-requests/{supplemental_request}', ['as' => 'voyager.supplemental-requests.destroy', 'uses' => 'SupplementalRequestController@destroy']);
});