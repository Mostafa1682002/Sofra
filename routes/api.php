<?php

use App\Http\Controllers\Api\Client\AuthClientController;
use App\Http\Controllers\Api\Client\MainClientController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\Restaurant\AuthRestaurantController;
use App\Http\Controllers\Api\Restaurant\MainResturantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => "v1"], function () {
    //Main Apis
    Route::group(['controller' => MainController::class], function () {
        Route::get('categories', 'categories');
        Route::get('cities', 'cities');
        Route::get('regoins', 'regoins');
        Route::get('offers', 'offers');
        Route::post('contact-us', 'contact');
        Route::get('settings', 'settings');
    });

    //Api Restaurant
    Route::group(['prefix' => "restaurant"], function () {
        //Auth Restaurant
        Route::group(['controller' => AuthRestaurantController::class], function () {
            Route::post('register', 'register');
            Route::post('login', 'login');
            Route::post('reset-password', 'resetPassword');
            Route::post('new-password', 'newPassword');
            Route::get('profile', 'profile')->middleware('auth:api_restaurant');
            Route::post('update-profile', 'updateProfile')->middleware('auth:api_restaurant');
            //Register Token
            Route::post('register-token', 'registerToken')->middleware('auth:api_restaurant');
            Route::post('remove-token', 'removeToken')->middleware('auth:api_restaurant');
        });

        //Main Restaurant
        Route::group(['controller' => MainResturantController::class, 'middleware' => 'auth:api_restaurant'], function () {
            //Products
            Route::get('products', 'products');
            Route::post('create-product', 'createProduct');
            Route::get('show-product/{id}', 'showProduct');
            Route::post('update-product/{id}', 'updateProduct');
            Route::post('delete-product/{id}', 'deleteProduct');
            //Offers
            Route::get('offers', 'offers');
            Route::post('create-offer', 'createOffer');
            Route::get('show-offer/{id}', 'showOffer');
            Route::post('update-offer/{id}', 'updateOffer');
            Route::post('delete-offer/{id}', 'deleteOffer');
            //Orders
            Route::get('orders', 'restaurantOrder');
            Route::post('accept-order/{id}', 'acceptOrder');
            Route::post('reject-order/{id}', 'rejectOrder');
            Route::post('confirm-order/{id}', 'confirmOrder');
            //transaction
            Route::get('transactions', 'transaction');
        });
    });

    //Api Client
    Route::group(['prefix' => "client"], function () {
        Route::group(['controller' => AuthClientController::class], function () {
            Route::post('register', 'register');
            Route::post('login', 'login');
            Route::post('reset-password', 'resetPassword');
            Route::post('new-password', 'newPassword');
            Route::get('profile', 'profile')->middleware('auth:api_client');
            Route::post('update-profile', 'updateProfile')->middleware('auth:api_client');
            //Register Token
            Route::post('register-token', 'registerToken')->middleware('auth:api_client');
            Route::post('remove-token', 'removeToken')->middleware('auth:api_client');
        });

        //Main Clients
        Route::group(['controller' => MainClientController::class], function () {
            Route::get('/restaurants', 'restaurants');
            Route::get('/restaurant/{id}', 'restaurant');
            //Orders
            Route::post('/new-order', 'newOrder')->middleware('auth:api_client');
            Route::get('my-orders', 'myOrders')->middleware('auth:api_client');
            Route::post('cancel-order/{id}', 'cancelOrder')->middleware('auth:api_client');
            Route::post('confirm-order/{id}', 'confirmOrder')->middleware('auth:api_client');
            //Add Review
            Route::post('add-review', 'addReview')->middleware('auth:api_client');
        });
    });
});