<?php


#============================ WMC Admin Routes =============================================

Route::namespace('WMCControllers')->group(function () {

    Route::group(['prefix' => 'auth'], function () {

        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('admin', 'AuthController@getAuthUser');
        Route::post('register', 'RegisterController@register');
    });

    Route::group(['prefix' => 'super_admin'], function (){

        Route::post('create/admin', 'SuperAdminController@newAdmin');

        Route::post('{admin}/block', 'SuperAdminController@blockAdmin');

        Route::post('{admin}/unblock', 'SuperAdminController@unBlockAdmin');

        Route::get('fetch-users', 'SuperAdminController@getUsers');

        Route::get('fetch-admins', 'SuperAdminController@fetchAdmins');

    });
});
#============================ End WMC Admin Route ==========================================
