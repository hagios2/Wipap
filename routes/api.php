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


Route::group(['prefix' => 'auth'], function ($router) {

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

Route::post('/register', 'Api\RegisterController@register');

Route::post('/update-profile', 'Api\RegisterController@update');

Route::post('/logout', 'Api\RegisterController@logoutApi');

Route::get('get/campus/{campus}/carousel', 'ResourceController@getCourosleIamges');

Route::get('categories', 'ProductsController@getCategories');

Route::get('category/{category}/products', 'ProductsController@getCategorysProduct');

Route::get('product/{product}/details', 'ProductsController@getProductDetails');

Route::get('/{category}/product-index', 'ProductsController@index');

Route::post('user/{user}/add-cart', 'ProductsController@saveCart');

Route::get('user-cart', 'ProductsController@getCart');

Route::get('shop-types', 'ResourceController@getShopTypes');

Route::get('merchandiser/{shops}/products','ProductsController@fetchShopsProduct');

Route::get('all-shops','ProductsController@fetchShops');

Route::get('get-campus/{campus}/shop','ProductsController@campusShop');

Route::get('get-campus/{campus}/product','ProductsController@campusProduct');

Route::post('follow/{shop}/shop','FollowersController@followShop');

Route::post('unfollow/{shop}/shop','FollowersController@unFollowShop');

Route::get('following-shops','FollowersController@fetchfollowingShops');

Route::post('make-enquiries','EnquiryFormController@handler');

Route::get('shop/{shop}/details', 'ProductsController@merchandiserDetails');

Route::get('shop/{merchandiser}/reviews', 'ReviewsController@fetchShopReviews');

Route::post('add-shop/reviews', 'ReviewsController@storeShopReview');

Route::get('product/{product}/reviews', 'ReviewsController@fetchProductReviews');

Route::post('add-product/reviews', 'ReviewsController@storeProductReview');

Route::post('add-product/report', 'ReportsController@saveProductReport'); 

Route::post('add-shop/report', 'ReportsController@saveShopReport'); 


Route::group(['prefix' => 'merchandiser'], function () {
    
    return response()->json(['message' => 'Route not found'],404);

})->name('api.fallback.404');


Route::group(['prefix' => 'payment'], function () {

    Route::get('/callback/{status}/{transac_id}/{cust_ref}/{pay_token}','PaymentController@callback');
    
});
