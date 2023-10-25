<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\RegoinController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['prefix' => 'admin'], function () {
    Auth::routes(['register' => false]);
    Route::get('/', function () {
        return view('auth.login');
    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::put('/update-profile', [HomeController::class, 'updateProfile'])->name('profile.update');
    //Cities
    Route::resource('cities', CityController::class);
    //Regoins
    Route::resource('regoins', RegoinController::class);
    //Categories
    Route::resource('categories', CategoryController::class);
    //Payment Method
    Route::resource('payment_types', PaymentTypeController::class);
    //Offers
    Route::resource('offers', OfferController::class);
    //Contacts
    Route::resource('contacts', ContactController::class);
    //Settings
    Route::resource('settings', SettingController::class);
    //Restaurants
    Route::resource('restaurants', RestaurantController::class);
    //Clients
    Route::resource('clients', ClientController::class);
    //Orders
    Route::resource('orders', OrderController::class);
    //Users
    Route::resource('users', UserController::class)->middleware('auth');
    //Roles
    Route::resource('roles', RoleController::class)->middleware('auth');
});
