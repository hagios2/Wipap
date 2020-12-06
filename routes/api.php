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

Route::namespace('UserControllers')->group(function (){

    Route::group(['prefix' => 'auth'], function () {

        Route::post('register', 'RegisterController@register');

        Route::post('login', 'AuthController@login');

        Route::post('logout', 'AuthController@logout');

        Route::post('refresh-token', 'AuthController@refresh');

        Route::get('user', 'AuthController@getAuthUser');

        Route::patch('update/{user}/user', 'UsersRegisterController@update');

        Route::delete('user/delete', 'UsersRegisterController@destroy');

        Route::post('email/verify', 'VerificationController@verify')->name('verification.verify'); // Make sure to keep this as your route name

        Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');

        Route::post('request/password/reset', 'PasswordResetController@sendResetMail');

        Route::post('reset/password/', 'PasswordResetController@reset');

        Route::post('change/password', 'PasswordResetController@changeUserPassword');

        Route::post('upload/valid-id', 'AuthController@saveValidId');

    });

    Route::post('/make-/bin/request', 'BinRequestController@binRequest');

});

Route::fallback(function(){

    return response()->json(['message' => 'Route not found'], 404);
});

Route::group(['prefix' => 'payment'], function () {

    Route::get('/callback/{status}/{transac_id}/{cust_ref}/{pay_token}','PaymentController@callback');

});


Route::get('garbage/types','ResourceController@getGarbageTypes');

Route::get('get/roles','ResourceController@roles');
