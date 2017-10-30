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

Route::middleware('auth:api')->group(function () {

    Route::get('/orders', 'OrderController@getUserOrders');
    Route::post('/orders', 'OrderController@store');
    Route::put('/orders', 'OrderController@confirmTransaction');
    Route::delete('/orders/{id}', 'OrderController@destroy');

});

Route::post('/register', 'UserController@create');

Route::get('/products', 'ProductController@index');
