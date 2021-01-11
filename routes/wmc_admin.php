<?php

use Illuminate\Support\Facades\Route;


#============================ WMC Admin Routes =============================================

Route::namespace('WMCControllers')->group(function () {

    Route::group(['prefix' => 'auth'], function () {

        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('admin', 'AuthController@getAuthUser');
        Route::post('register', 'RegisterController@register');
        Route::get('admin-company', 'AuthController@getcompanyDetails');
    });

    #============================ WMC Super Admin Routes =========================

    Route::group(['prefix' => 'super_admin'], function (){

        Route::post('create/admin', 'SuperAdminController@newAdmin');

        Route::post('{admin}/block', 'SuperAdminController@blockAdmin');

        Route::post('{admin}/unblock', 'SuperAdminController@unBlockAdmin');

//        Route::get('fetch-users', 'SuperAdminController@getUsers');

        Route::get('fetch-admins', 'SuperAdminController@fetchAdmins');

        Route::post('/publish-company', 'SuperAdminController@publishCompany');

        Route::post('/unpublish-company', 'SuperAdminController@unpublishCompany');

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


    #============================ WMC Pickup and Pickup Request Routes ==========================

    Route::group(['prefix' => 'pickups'], function () {

        Route::post('create', 'PickupController@setPickupDays');

        Route::get('index', 'PickupController@viewPickUpDays');

        Route::get('requests', 'PickupController@viewPickRequest');

        Route::post('request/{pickUpRequest}/serve', 'PickupController@servePickRequest');

        Route::delete('{pickUp}/delete', 'PickupController@destroy');
    });

    #============================ End WMC Pickup and Pickup Request Routes ========================


    Route::post('/wmc/payment', 'WMCPaymentController@payment')->name('wmc.pay');

    Route::get('wmc/payment/transactions', 'WMCPaymentController@paymentTransactions');

    Route::post('/wmc/payment/callback', 'WMCPaymentController@callback')->name('wmc.payment.callback');

#------------------------ End of Payment Integration ----------------------------------------------
});
#============================ End WMC Admin Route ==========================================
