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

Route::post('/register', 'Api\RegisterController@register');

Route::post('/update-profile', 'Api\RegisterController@update');

Route::post('/logout', 'Api\RegisterController@logoutApi');

Route::fallback(function () {
    
    return response()->json(['message' => 'Route not found'],404);

})->name('api.fallback.404');


Route::group(['prefix' => 'payment'], function () {

    Route::get('/callback/{status}/{transac_id}/{cust_ref}/{pay_token}','PaymentController@callback');
    
});
