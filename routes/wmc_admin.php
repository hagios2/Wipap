<?php


#============================ WMC Admin Routes =============================================

Route::namespace('WMCControllers')->group(function () {

    Route::group(['prefix' => 'auth'], function () {

        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
        Route::post('register', 'RegisterController@me');

    });
});
#============================ End WMC Admin Route ==========================================
