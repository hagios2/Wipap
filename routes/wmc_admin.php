<?php


#============================ WMC Admin Routes =============================================

Route::namespace('WMCControllers')->group(function () {

    Route::group(['prefix' => 'auth'], function () {

        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('admin', 'AuthController@authAdmin');
        Route::post('register', 'RegisterController@register');

    });
});
#============================ End WMC Admin Route ==========================================
