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

Route::post('/manufacturer', 'ManufacturerController@store');
Route::get('/manufacturer-list', 'ManufacturerController@getList');
Route::post('/car-model', 'CarModelController@store');
Route::get('/car-model-list', 'CarModelController@getCarModelList');
Route::delete('/car-model/{carModel}', 'CarModelController@destroy');

Route::group(['middleware' => 'auth:api'], function(){

    // Add Route which need Authentication and authorization

});