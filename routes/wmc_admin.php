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

    #============================ WMC Super Admin Routes =========================

    Route::group(['prefix' => 'super_admin'], function (){

        Route::post('create/admin', 'SuperAdminController@newAdmin');

        Route::post('{admin}/block', 'SuperAdminController@blockAdmin');

        Route::post('{admin}/unblock', 'SuperAdminController@unBlockAdmin');

//        Route::get('fetch-users', 'SuperAdminController@getUsers');

        Route::get('fetch-admins', 'SuperAdminController@fetchAdmins');

    });

    #============================ End WMC Super Admin Routes =====================

    #============================ WMC VehicleRoutes ========================

    Route::group(['prefix' => 'vehicle'], function () {

        Route::post('create', 'VehicleController@addVehicle');

        Route::get('index', 'VehicleController@fetchVehicles');

        Route::patch('{vehicle}/update', 'VehicleController@updateVehicle');

        Route::delete('{vehicle}/delete', 'VehicleController@deleteVehicle');

    });

    #============================ End WMC VehicleRoutes ========================
});
#============================ End WMC Admin Route ==========================================
